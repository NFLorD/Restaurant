<?php 
require "_Controller.php";

class ReservationsController extends Controller
{
    protected $modelName = "Reservations";

    public function index(string $mode = "visitor")
    {
        if ($mode == "admin") {
            $title = "Liste des réservations";
            $reservations = $this->model->findAll();
            $this->display("reservationslist", compact("title", "reservations"));
        } else {
            $title = "Mes réservations";
            $reservations = $this->model->find($_SESSION['user']['id'], "customer_id", true, " ORDER BY date");
            $this->display("reservationslist", compact("title", "reservations"));
        }
    }

    public function show()
    {

    }

    public function upsert(string $mode = "visitor")
    {
        if (empty($_POST)) {
            $title = "Réservation";
            $template = "newreservation";
            if (!empty($_GET['id'])) {
                $title = "Modification d'une réservation";
                $reservation = $this->model->find($_GET['id']);
                $reservation['time'] = substr($reservation['date'], -8, -3);
                $reservation['date'] = substr($reservation['date'], 0, -9);
            }
            require ROOT . "/templates/template.phtml";
            exit;
        }

        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['number']) || empty($_POST['date']) || empty($_POST['time'])) {
            Session::addError("Vous devez remplir tous les champs.");
            Http::redirectBack();
        }

        $date = $_POST['date'] . " " . $_POST['time'];
        $email = $_POST['email'];
        $number = $_POST['number'];

        if (empty($_GET['id'])) {
            $password = password_hash(time(), PASSWORD_DEFAULT);
            if ($_SESSION['connected']) {
                $created = $this->model->create(['name' => $_POST['name'], 'email' => $_POST['email'], 'number' => $_POST['number'], 'date' => $date, 'password' => $password, 'customer_id' => $_SESSION['user']['id']]);
            } else {
                $created = $this->model->create(['name' => $_POST['name'], 'email' => $_POST['email'], 'number' => $_POST['number'], 'date' => $date, 'password' => $password]);
            }
            if ($created == 0) {
                Session::addError("Une erreur s'est produite.");
            } else {
                Session::addSuccess("Votre réservation du " . $_POST['date'] . " a bien été enregistrée !");
                $headers = array(
                    'From' => 'webmaster@cheznico.com',
                    'Reply-To' => 'webmaster@cheznico.com',
                    'X-Mailer' => 'PHP/' . phpversion()
                );
                $sent = mail($email, "Réservation - Chez Nico'", "Vous avez réservé pour $number personne(s) le $date.\n 
                Pour tout changement, suivez ce lien : localhost/Restaurant/reservations/update/$password,\n
                pour la supprimer : localhost/Restaurant/reservations/delete/$password", $headers);
                var_dump($sent);
                exit;
            }
            Http::redirectBack();
        } else {
            if(is_int($_GET['id'])){
                $this->model->update('id', $_GET['id'], ['name' => $_POST['name'], 'email' => $_POST['email'], 'number' => $_POST['number'], 'date' => $date]);
            } else {
                $this->model->update('password', $_GET['id'], ['name' => $_POST['name'], 'email' => $_POST['email'], 'number' => $_POST['number'], 'date' => $date]);
            }
            Session::addSuccess("Votre modification a bien été prise en compte.");
            Http::redirectBack();
        }
    }

    public function delete()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!is_int($id)) {
            Http::redirect(WEB_ROOT);
        }

        $reservation = $this->model->find($id);

        if ($reservation['customer_id'] == $_SESSION['user']['id'] || $_SESSION['user']['id'] == 1) {
            $this->model->delete($id);
            Session::addSuccess("Réservation supprimée.");
        }

        Http::redirectBack();
    }
}


?>