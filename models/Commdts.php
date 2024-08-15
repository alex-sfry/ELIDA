<?php

namespace app\models;

use app\behaviors\CommoditiesBehavior;
use app\behaviors\StationBehavior;
use app\behaviors\SystemBehavior;
use Yii;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use yii\helpers\Url;

class Commdts extends Model
{
    public ?array $commodities_arr = null;
    public ?string $refSystem = null;
    public ?string $landingPadSize = null;
    public ?string $includeSurface = null;
    public ?string $distanceFromStar = null;
    public ?string $minSupplyDemand = null;
    public ?string $buySellSwitch = null;
    public ?string $maxDistanceFromRefStar = null;
    public ?string $dataAge = null;
    public ?string $stock_demand = null;
    public ?string $price_type = null;
    protected ?array $commodities = null;

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

    public function setCommodities(array $commodities): void
    {
        $this->commodities = $commodities;
    }

    public function getQuery(): Query
    {
        /** @var SystemBehavior|CommoditiesBehavior|Commdts $this */

        $distance_expr = $this->getDistanceToSystemExpression($this->refSystem);
        $c_symbols = [];

        foreach ($this->commodities_arr as $item) {
            $c_symbols[] = array_search($item, $this->commodities);
        }

        $prices = (new Query())
            ->select([
                $this->price_type,
                $this->stock_demand,
                'm.name AS commodity',
                'st.name AS station',
                'st.id AS station_id',
                'type',
                'distance_to_arrival AS distance_ls',
                'systems.name AS system',
                'systems.id AS system_id',
                "$distance_expr AS distance_ly",
                'TIMESTAMP',
                'TIMESTAMPDIFF(MINUTE, TIMESTAMP, NOW()) as time_diff',
            ])
            ->from(['m' => 'markets'])
            ->innerJoin(['st' => 'stations'], 'm.market_id = st.market_id')
            ->innerJoin('systems', 'st.system_id = systems.id')
            ->where(['m.name' => $c_symbols])
            ->andWhere(['>', $this->stock_demand, 1]);

        $this->landingPadSize === 'L' && $prices->andWhere(['not', ['type' => 'Outpost']]);

        $this->includeSurface === 'No' &&
            $prices->andWhere(['not in', 'type', ['Planetary Port', 'Planetary Outpost', 'Odyssey Settlement']]);

        $this->distanceFromStar !== 'Any' &&
            $prices->andWhere(['<=', 'distance_to_arrival', $this->distanceFromStar]);

        if ($this->minSupplyDemand !== 'Any') {
            $this->buySellSwitch === 'buy' &&
                $prices->andWhere(['>=', 'stock', $this->minSupplyDemand]);
            $this->buySellSwitch === 'sell' &&
                $prices->andWhere(['>=', 'demand', $this->minSupplyDemand]);
        }

        $this->maxDistanceFromRefStar !== 'Any' && $prices->andWhere([
            '<=',
            $distance_expr,
            $this->maxDistanceFromRefStar,
        ]);

        $date_sub_expr = new Expression("DATE_SUB(NOW(), INTERVAL {$this->dataAge} HOUR)");

        $this->dataAge !== 'Any' && $prices->andWhere(['>', 'TIMESTAMP', $date_sub_expr]);

        return $prices;
    }

    public function modifyModels(array $models): array
    {
        /** @var StationBehavior|CommoditiesBehavior|Commdts $this */

        foreach ($models as $key => $value) {
            $value['commodity'] = isset($this->commodities[strtolower($value['commodity'])]) ?
                $this->commodities[strtolower($value['commodity'])] : $value['commodity'];
            $value['pad'] = $this->getLandingPadSizes()[$value['type']];
            $value['time_diff'] = Yii::$app->formatter->asRelativeTime($value['TIMESTAMP']);
            $value['surface'] = match ($value['type']) {
                'Planetary Outpost', 'Planetary Port', 'Odyssey Settlement' => true,
                default => false,
            };
            $value['station'] = [
                'text' => $value['station'],
                'url' => Url::toRoute(["station/{$value['station_id']}"])
            ];
            $value['system'] = [
                'text' => $value['system'],
                'url' => Url::toRoute(["system/{$value['system_id']}"])
            ];

            $models[$key] = $value;
        }

        return $models;
    }
}
