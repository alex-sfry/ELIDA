export const shipModulesForm = (loader, removeLoader) => {
    const $form = $('#mod-form');
    const $table = $('.mod-table');
    removeLoader($table);

    const handleSubmit = (e) => {
        if (!$form.get(0).checkValidity()) {
            e.preventDefault();
        } else loader($form, $table);
    };

    $form.on('submit', handleSubmit);

};
