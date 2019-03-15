<?php 
require "_Controller.php";

class OrdersController extends Controller
{
    protected $modelName = "Orders";

    public function index(string $mode = "visitor")
    {
        // Vers la liste des plats du mode admin
        if ($mode == "admin") {
            $title = "Liste des plats";
            $template = "disheslist";
            $desserts = $this->model->find("dessert", "type", true);
            $dishes = $this->model->find("dish", "type", true);
            $appetizers = $this->model->find("appetizer", "type", true);
            $dishes = [$appetizers, $dishes, $desserts];
            $this->display($template, compact("title", "dishes"));
        }
        // Vers la commande
        else {
            $desserts = $this->model->find("dessert", "type", true);
            $dishes = $this->model->find("dish", "type", true);
            $appetizers = $this->model->find("appetizer", "type", true);

            $title = "Commander";
            $template = "order";
            $this->display($template, compact("title", "dishes", "appetizers", "desserts"));
        }
    }

    public function show()
    {

    }

    public function upsert()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (empty($_POST)) {
            $title = "Nouveau plat";
            $template = "newdish";
            if (!empty($_GET['id'])) {
                $title = "Modification d'un plat";
                $dish = $this->model->find($_GET['id']);
            }
            require ROOT . "/templates/template.phtml";
            exit;
        }

        if (empty($_POST['name'])) {
            Session::addError("Vous n'avez rien entré !");
            Http::redirectBack();
        }

        if (empty($_POST['description'])) {
            $_POST['description'] = 'NULL';
        }

        if (empty($_POST['price'])) {
            $_POST['price'] = 'NULL';
        }

        if (!$id) {
            $upserted = $this->model->create(['name' => $_POST['name'], 'description' => $_POST['description'], 'type' => $_POST['type'], 'price' => $_POST['price']]);
            if ($upserted == 0) {
                Session::addError("Une erreur s'est produite.");
                Http::redirectBack();
            }
        } else {
            $this->model->update('id', $_GET['id'], ['name' => $_POST['name'], 'description' => $_POST['description'], 'type' => $_POST['type'], 'price' => $_POST['price']]);
        }

        Http::redirect(WEB_ROOT . "/admin/dishes");
    }

    public function delete()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            Http::redirect(WEB_ROOT . "/admin");
        }

        $this->model->delete($id);

        Http::redirectBack();
    }
}


?>