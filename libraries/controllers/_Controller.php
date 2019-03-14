<?php 
require ROOT . "/libraries/models/CustomersModel.php";
require ROOT . "/libraries/models/DishesModel.php";
require ROOT . "/libraries/models/ReservationsModel.php";

abstract class Controller
{
    protected $model;
    protected $modelName;

    public function __construct()
    {
        $this->model = new $this->modelName();
    }

    protected function display(string $template, array $variables)
    {
        extract($variables);
        require ROOT . "/templates/template.phtml";
        exit;
    }
}

?>