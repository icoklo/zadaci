<?php

// camelCase
function str_cammel_case($str)
{
    $result = ucwords(implode('_', [$str]), '_'); // Get_First_Name_Attr
    $result = lcfirst(str_replace('_', '', $result)); // getFirstNameAttr
    return $result;
}

// PascalCase
function str_pascal_case($str)
{
    $result = ucwords(implode('_', [$str]) , '_'); // Get_First_Name_Attr
    $result = str_replace('_', '', $result); // GetFirstNameAttr
    return $result;
}
