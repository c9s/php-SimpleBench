<?php
require( 'tests/bootstrap.php');

$bench = new SimpleBench;
$bench->setN( 50000 );
$bench->setTitle( 'i18n' );

function apc_loc($msg)
{
    if( $ret = apc_fetch( 'i18n_' . $msg ) )
        return $ret;
    $trans = _($msg);
    apc_store( 'i18n_' . $msg , $trans );
    return $trans;
}

$bench->iterate( 'apc_loc' , 'loc' , function() {
    apc_loc('Hello World');
});

$bench->iterate( 'gettext' , 'gettext' , function() {
    _('Hello World');
});


$hash = array(
    'en' => array( 'Hello World' => 'Hello World' ),
);

$bench->iterate( 'array' , 'array' , function() use($hash) {
    $hash['en']['Hello World'];
});

$result = $bench->compare();
echo $result->output('console');
