<?php 
if(!array_key_exists('P', $_GET) || empty($_GET['P']))
$_GET['P'] = 'home';

	switch ($_GET['P']) 
    {
		case 'login': !isUserLoggedIn() ? require_once PROTECTED_DIR.'user/login.php' : header('Location: index.php'); break;
        case 'register': !isUserLoggedIn() ? require_once PROTECTED_DIR.'user/register.php' : header('Location: index.php'); break;
		case 'home':  require_once PROTECTED_DIR.'home.php'; break;
		case 'logout': userLogout(); break;
		case 'answerSurvey' : require_once PROTECTED_DIR.'survey/uncompleted_surveys.php'; break;
		case 'editUser' : isUserLoggedIn() ? require_once PROTECTED_DIR.'user/editUser.php' : header('Location: index.php'); break;
		case 'newSurveyUpload': isUserLoggedIn() && $_SESSION['permission']  > 0 ? require_once PROTECTED_DIR.'admin/add_survey.php' : header('Location: index.php'); break;
		case 'addNewQuestion': isUserLoggedIn() && $_SESSION['permission']  > 0 ? require_once PROTECTED_DIR.'admin/add_question.php' : header('Location: index.php'); break;
		case 'listUser': isUserLoggedIn() && $_SESSION['permission'] > 0 ? require_once PROTECTED_DIR.'admin/listUser.php' : header('Location: index.php'); break;
		case 'completedSurveys'  : isUserLoggedIn() ? require_once PROTECTED_DIR.'survey/completed_surveys.php' : header('Location: index.php'); break;
		case 'topics'  : isUserLoggedIn() ? require_once PROTECTED_DIR.'survey/topics.php' : header('Location: index.php'); break;
		case 'modifyUserAdmin' : isUserLoggedIn() && $_SESSION['permission'] > 0 ? require_once PROTECTED_DIR.'admin/modifyUserFromAdmin.php' : header('Location: index.php'); break;
		case 'averages' : isUserLoggedIn() ? require_once PROTECTED_DIR.'survey/average.php' : header('Location: index.php'); break;
		case 'answerJustSurvey':  require_once PROTECTED_DIR.'survey/ans_survey.php';  break;
		case 'averagesspecific': require_once PROTECTED_DIR.'survey/averagesspecific.php'; break;
		case 'statistics': require_once PROTECTED_DIR.'survey/statistics.php'; break;
		case 'profile': isUserLoggedIn() ? require_once PROTECTED_DIR.'user/myprofile.php' : header('Location: index.php'); break;
		default: require_once PROTECTED_DIR.'404.php'; break;
	}


?>