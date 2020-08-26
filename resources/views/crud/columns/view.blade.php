@includeWhen(!empty($column['wrapper']), 'skote::crud.columns.inc.wrapper_start')
    @include($column['view'])
@includeWhen(!empty($column['wrapper']), 'skote::crud.columns.inc.wrapper_end')
