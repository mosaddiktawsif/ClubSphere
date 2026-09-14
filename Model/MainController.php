<?php
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../Model/CaptainModel.php';
require_once __DIR__ . '/../Model/Tournament.php';

class MainController {
    private $db;
    private $captainModel;
    private $tournamentModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->captainModel = new CaptainModel($this->db);
        $this->tournamentModel = new Tournament($this->db);
    }

    public function loadLogin() {
        require_once __DIR__ . '/../View/login.php';
    }

    public function loadRegister() {
        require_once __DIR__ . '/../View/register.php';
    }

    public function login() {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $user = $this->captainModel->getCaptainByEmail($email);
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['captain_id'] = $user['id'];
                $_SESSION['ign'] = $user['ign'];
                
                if (isset($_POST['remember_me'])) {
                    setcookie("remember_email", $email, time() + (86400 * 30), "/"); 
                } else {
                    setcookie("remember_email", "", time() - 3600, "/"); 
                }
                
                header("Location: index.php?action=dashboard");
                exit;
            }
        }
        header("Location: index.php?action=login_page&error=invalid");
    }

    public function register() {
        if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password'])) {
            $this->captainModel->registerCaptain(
                $_POST['name'], 
                $_POST['phone'], 
                $_POST['email'], 
                $_POST['ign'], 
                $_POST['game'], 
                $_POST['password']
            );
            header("Location: index.php?action=login_page&success=registered");
        }
    }

    public function loadDashboard() {
        if (!isset($_SESSION['captain_id'])) { 
            header("Location: index.php"); 
            exit; 
        }
        $tournaments = $this->tournamentModel->getUpcomingTournaments();
        require_once __DIR__ . '/../View/captaindashboard.php';
    }

    public function loadRoster() {
        if (!isset($_SESSION['captain_id'])) { 
            header("Location: index.php"); 
            exit; 
        }
        $roster = $this->captainModel->getTeamRoster($_SESSION['captain_id']);
        require_once __DIR__ . '/../View/rosterinfo.php';
    }

    public function addRoster() {
        if (!empty($_POST['ign']) && !empty($_POST['real_name'])) {
            $this->captainModel->addRosterMember(
                $_SESSION['captain_id'], 
                $_POST['real_name'], 
                $_POST['ign'], 
                $_POST['phone']
            );
        }
        header("Location: index.php?action=roster");
    }

    public function editRoster() {
        if (!empty($_POST['member_id']) && !empty($_POST['ign'])) {
            $this->captainModel->updateRosterMember(
                $_POST['member_id'], 
                $_SESSION['captain_id'], 
                $_POST['real_name'], 
                $_POST['ign'], 
                $_POST['phone']
            );
        }
        header("Location: index.php?action=roster");
    }

    public function deleteRosterAjax($member_id) {
        header('Content-Type: application/json');
        $success = $this->captainModel->deleteRosterMember($member_id, $_SESSION['captain_id']);
        echo json_encode(array('status' => $success ? 'success' : 'error'));
    }

    public function loadTournaments() {
        if (!isset($_SESSION['captain_id'])) { 
            header("Location: index.php"); 
            exit; 
        }
        $tournaments = $this->tournamentModel->getUpcomingTournaments();
        require_once __DIR__ . '/../View/tournaments_2.php';
    }

    public function enrollTournament() {
        if (!empty($_POST['tournament_id'])) {
            $this->captainModel->registerForTournament($_SESSION['captain_id'], $_POST['tournament_id']);
        }
        header("Location: index.php?action=tournaments");
    }

    public function submitScore() {
        if (!empty($_POST['tournament_id']) && !empty($_POST['score']) && isset($_FILES['screenshot'])) {
            if ($_FILES['screenshot']['error'] == 0) {
                $fileName = time() . '_' . basename($_FILES['screenshot']['name']);
                $uploadPath = 'uploads/' . $fileName;
                
                if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $uploadPath)) {
                    $this->captainModel->submitScoreProof(
                        $_SESSION['captain_id'], 
                        $_POST['tournament_id'], 
                        $_POST['score'], 
                        $uploadPath
                    );
                }
            }
        }
        header("Location: index.php?action=dashboard");
    }

    public function logout() {
        session_destroy();
        header("Location: index.php");
    }
}
?>