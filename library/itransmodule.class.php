<?php
namespace Jip\Library;

interface ITransModule {
    function get($key);
    function getAll();
    function getLastModified();
}
?>