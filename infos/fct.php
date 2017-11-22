<?php 

/**
 * 
 * @param mixed $val
 * @param mixed $_
 * @return boolean
 */
function in($val, $_ = NULL) {
    if (!is_array($_)) {
        $_ = func_get_args();
        array_shift($_);
    }
    return in_array($val, $_);
}