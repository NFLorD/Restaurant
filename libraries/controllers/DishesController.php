<?php 
require "_Controller.php";

class DishesController extends Controller
{
    protected $modelName = "Dishes";

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
        if ($_GET['type'] == "appetizers") {
            $title = "Nos entrées";
            $dishes = $this->model->find("appetizer", "type", true);
        }
        if ($_GET['type'] == "dishes") {
            $title = "Les plats";
            $dishes = $this->model->find("dish", "type", true);
        }
        if ($_GET['type'] == "desserts") {
            $title = "Les desserts";
            $dishes = $this->model->find("dessert", "type", true);
        }
        $template = "menu";
        $this->display($template, compact("title", "dishes"));
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

        if (!is_int($id)) {
            Http::redirect(WEB_ROOT . "/admin");
        }

        $this->model->delete($id);

        Http::redirectBack();
    }

    public function cart()
    {
        if (!empty($_POST)) {
            // $desserts = $this->model->find("dessert", "type", true);
            // $dishes = $this->model->find("dish", "type", true);
            // $appetizers = $this->model->find("appetizer", "type", true);
            // $dishes = [$appetizers, $dishes, $desserts];
            $orderedAppetizers = [];
            $orderedDishes = [];
            $orderedDesserts = [];
            foreach ($_POST['appetizersQty'] as $id => $qty) {
                if ($qty != 0) {
                    $orderedAppetizers[$id] = ["qty" => $qty, "details" => $this->model->find($id)];
                }
            }
            foreach ($_POST['dishesQty'] as $id => $qty) {
                if ($qty != 0) {
                    $orderedDishes[$id] = ["qty" => $qty, "details" => $this->model->find($id)];
                }
            }
            foreach ($_POST['dessertsQty'] as $id => $qty) {
                if ($qty != 0) {
                    $orderedDesserts[$id] = ["qty" => $qty, "details" => $this->model->find($id)];
                }
            }
            $_SESSION['ordering'] = true;
            $_SESSION['cart'] = ["appetizers" => $orderedAppetizers, "dishes" => $orderedDishes, "desserts" => $orderedDesserts];
            $_SESSION['total'] = 0;
            foreach ($_SESSION['cart'] as $category) {
                foreach ($category as $dish) {
                    $_SESSION['total'] += $dish['qty'] * $dish['details']['price'];
                }
            }
        }

        if (!$_SESSION['ordering']) {
            Http::redirect(WEB_ROOT . "/home");
        }

        // var_dump($_SESSION['cart']);
        // exit;
        $title = "Ma commande";
        $template = "cart";
        $this->display($template, compact("title"));
    }

    public function cancel()
    {
        $_SESSION['ordering'] = false;
        $_SESSION['cart'] = [];
        $_SESSION['total'] = 0;
        Http::redirect(WEB_ROOT . "/home");
    }
}


?>