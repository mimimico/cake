<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: index
 *  @Project: Proto Engine 3
 */
require("project.php");

peLoader::import("providers.peController");
peLoader::import("providers.peTemplate");
peLoader::import("models.miUser");

peTemplate::main(
    peController::getData()
);