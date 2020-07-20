<?php

    function changeTypeVar(String $stringVar) {
        switch(True) {
            case is_numeric($stringVar):

                $stringVar = intval($stringVar);
                break;

            case strtolower($stringVar) == "false":
            case strtolower($stringVar) == "true":

                $stringVar = (strtolower($stringVar) == "true") ? true : false;
                break;

            case strtolower($stringVar) == "null":

                $stringVar = null;
                break;

            default:
                break;
        }

        return $stringVar;
    }
?>