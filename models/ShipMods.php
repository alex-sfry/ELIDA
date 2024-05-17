<?php

namespace app\models;

use app\behaviors\StationBehavior;
use app\behaviors\SystemBehavior;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\base\Model;

class ShipMods extends Model
{
    private array $mods_arr = [];

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                SystemBehavior::class,
                StationBehavior::class,
            ]
        );
    }

    public function __construct($mods)
    {
        $this->mods_arr = $mods;
    }

    /**
     * @param string $sys_name
     * @param array $get
     * @param int $limit
     *
     * @return \yii\data\ActiveDataProvider
     */
    public function getModules(string $sys_name, array $get, int $limit): ActiveDataProvider
    {
        extract($this->getCoords($sys_name));
        $mod_symbols = [];

        foreach ($this->mods_arr as $key => $value) {
            if (in_array($value, $get['cMainSelect'])) {
                $mod_symbols[] = $key;
            }
        }

        $modules = (new Query())
            ->select([
                'm.name AS module',
                'pl.price',
                'st.name AS station',
                'st.id AS station_id',
                'type',
                'distance_to_arrival AS distance_ls',
                'sys.name AS system',
                "ROUND(SQRT(POW((sys.x - $x), 2) + POW((sys.y - $y), 2) + POW((sys.z - $z), 2)), 2) AS distance_ly",
                'TIMESTAMP',
                'TIMESTAMPDIFF(MINUTE, TIMESTAMP, NOW()) as time_diff',
            ])
            ->from(['m' => 'ship_modules'])
            ->innerJoin(['st' => 'stations'], 'm.market_id = st.market_id')
            ->innerJoin(['sys' => 'systems'], 'st.system_id = sys.id')
            ->innerJoin(['pl' => 'modules_price_list'], 'm.name = pl.symbol')
            ->where(['m.name' => $mod_symbols]);

        $get['landingPadSize'] === 'L' && $modules->andWhere(['not', ['type' => 'Outpost']]);

        $get['includeSurface'] === 'No' &&
        $modules->andWhere(['not in', 'type', ['Planetary Port', 'Planetary Outpost', 'Odyssey Settlement']]);

        $get['distanceFromStar'] !== 'Any' &&
        $modules->andWhere(['<=', 'distance_to_arrival', $get['distanceFromStar']]);

        $get['maxDistanceFromRefStar'] !== 'Any' && $modules->andWhere([
            '<=',
            "ROUND(SQRT(POW((sys.x - $x), 2) + POW((sys.y - $y), 2) + POW((sys.z - $z), 2)), 2)",
            $get['maxDistanceFromRefStar'],
        ]);

        $date_sub_expr = new Expression("DATE_SUB(NOW(), INTERVAL {$get['dataAge']} HOUR)");

        $get['dataAge'] !== 'Any' &&
        $modules->andWhere(['>', 'TIMESTAMP', $date_sub_expr]);

        switch ($get['sortBy']) {
            case 'Updated_at':
                $sort_attr = 'time_diff';
                $sort_order = SORT_ASC;
                break;
            case 'Distance':
                $sort_attr = "distance_ly";
                $sort_order = SORT_ASC;
                break;
            default:
                $sort_attr = 'module';
                $sort_order = SORT_ASC;
        }

        return new ActiveDataProvider(config: [
            'query' => $modules,
            'pagination' => [
                'pageSizeLimit' => [0, $limit],
                'defaultPageSize' => $limit,
            ],
            'sort' => [
                'attributes' => [
                    'distance_ly',
                    'time_diff',
                    'module'
                ],
                'defaultOrder' => [
                    $sort_attr => $sort_order
                ],
            ],
        ]);
    }

    /**
     * @param array $models
     *
     * @return array
     */
    public function modifyModels(array $models): array
    {
        foreach ($models as $key => $value) {
            $value['module'] = isset($this->mods_arr[strtolower($value['module'])]) ?
                $this->mods_arr[strtolower($value['module'])] : $value['module'];
            $value['pad'] = $this->getLandingPadSizes()[$value['type']];
            $value['time_diff'] = Yii::$app->formatter->asRelativeTime($value['TIMESTAMP']);
            $value['surface'] = match ($value['type']) {
                'Planetary Outpost', 'Planetary Port', 'Odyssey Settlement' => true,
                default => false,
            };

            $models[$key] = $value;
        }

        return $models;
    }

    /**
     * @param int $id
     * @param string $cat
     *
     * @return array
     */
    public function getStationModules(int $id, string $cat): array
    {
        $modules = ShipModules::find()
            ->select([
                'ship_modules.name',
                'mlst.symbol',
                'category',
                'ship',
                'price',
                'timestamp',
                'market_id'
            ])
            ->innerJoin(['mlst' => 'ship_modules_list'], 'mlst.symbol = ship_modules.name')
            ->innerJoin(['mprc' => 'modules_price_list'], 'mprc.symbol = ship_modules.name')
            ->where(['market_id' => $id])
            ->asArray();

        switch ($cat) {
            case 'armour':
                $modules->andWhere(['category' => 'standard']);
                $modules->andWhere(['like', 'ship_modules.name', '_Armour_']);
                break;
            case 'core':
                $modules->andWhere(['category' => 'standard']);
                $modules->andWhere(['not like', 'ship_modules.name', '_Armour_']);
                break;
            case 'internal':
                $modules->andWhere(['category' => 'internal']);
                break;
            case 'utility':
                $modules->andWhere(['category' => 'utility']);
                break;
            case 'hardpoint':
                $modules->andWhere(['category' => 'hardpoint']);
                break;
            default:
                $modules->andWhere(['category' => 'hardpoint']);
        }

        $provider = new ActiveDataProvider(config: [
            'query' => $modules,
            'pagination' => [
                'pageSizeLimit' => [0, 00],
                'defaultPageSize' => 500,
            ],
        ]);

        $models = $provider->getModels();

        foreach ($models as $key => $value) {
            $models[$key]['m_name'] = isset($this->mods_arr[strtolower($value['name'])]) ?
                $this->mods_arr[strtolower($value['name'])] : $value['name'];
            $models[$key]['timestamp'] = Yii::$app->formatter->asRelativeTime($value['timestamp']);

            if (preg_match('/^.+_Armour_.+$/', $value['symbol'])) {
                $value['category'] = 'armour';
            }
        }

        return $models;
    }
}