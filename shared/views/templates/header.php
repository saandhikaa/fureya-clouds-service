<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data["title"] ?></title>
    
    <link rel="stylesheet" href="<?= BASEURL . '/' . $data["mainApp"] ?>/assets/css/style.css">
    <?= isset($data["styles"]) ? $data["styles"] : "" ?>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500&display=swap" rel="stylesheet">
</head>

<body>
    <header id="page-header" class="mobile">
        <h1><?= ucfirst($data["app"]) ?></h1>
        <button type="button" class="openNav nav-button"><?= isset($_SESSION["sign-in"]["username"]) ? '<span>' . strtoupper($_SESSION["sign-in"]["username"][0]) . '</span>' : (function() { readfile(__DIR__ . '/../../assets/images/icons/menu_FILL0_wght400_GRAD0_opsz24.svg'); })() ?></button>
    </header>
    
    <?= isset($data["image-path"]) ? $data["image-path"] : "" ?>
    
    <div class="navigation-container closeNav">
        <nav class="navigation">
            <header class="mobile">
                <section>
                    <?= isset($_SESSION["sign-in"]["username"]) ? '<h1>Hi, ' . $_SESSION["sign-in"]["username"] . '</h1>' : '<h1 class="nav-greeting"></h1>' ?>
                </section>
                <button type="button" class="closeNav nav-button"><?php readfile(__DIR__ . '/../../assets/images/icons/close_FILL0_wght400_GRAD0_opsz24.svg') ?></button>
                <span class="separator bottom"></span>
            </header>
            
            <h1 class="desktop"><?= ucfirst($data["app"]) ?></h1>
            
            <section class="list">
                <ul class="main-list row">
                    <li><a href="<?= BASEURL ?>/home"><?php readfile(__DIR__ . '/../../assets/images/icons/home_FILL0_wght400_GRAD0_opsz24.svg') ?><span>Home</span></a></li>
                    <li class="mobile"><a href="<?= BASEURL ?>/account"><?php readfile(__DIR__ . '/../../assets/images/icons/person_FILL0_wght400_GRAD0_opsz24.svg') ?><span>Account</span></a></li>
                </ul>
                <ul class="app-list row">
                    <h6 class="mobile">Services</h6>
                    <?php foreach (App::getAppListNavigation() as $appControllers): ?>
                        <?php foreach ($appControllers as $controller): ?>
                            <li><a href="<?= BASEURL .  '/' . strtolower($controller) ?>"><?= $controller ?></a></li>
                        <?php endforeach ?>
                    <?php endforeach ?>
                </ul>
            </section>
            
            <footer>
                <span class="separator top"></span>
                <button class="feedbackList desktop">Feedback <?php readfile(__DIR__ . '/../../assets/images/icons/expand_more_FILL0_wght400_GRAD0_opsz24.svg') ?></button>
                <ul class="row feedback-list">
                    <li><a href=""><span class="mobile">Leave a </span>Comment</a></li>
                    <li><a href="<?= $data['issue'] ?>" target="_blank"><span class="mobile">Create an Issue on GitHub</span><span class="desktop">GitHub Issue</span></a></li>
                </ul>
                <p class="copyright mobile"><span></span> <?= ME ?>.</p>
                <ul class="footer-list mobile">
                    <li><a href="">About</a></li>
                    <li><a href="">Resources</a></li>
                    <li><a href="">Terms</a></li>
                    <li><a href="">Privacy</a></li>
                </ul>
            </footer>
            
            <section class="account-info desktop">
                <?php if(isset($_SESSION["sign-in"]["username"])): ?>
                    <a href="<?= BASEURL ?>/account"><?= $_SESSION["sign-in"]["username"] ?></a>
                <?php else: ?>
                    <a href="<?= BASEURL ?>/account/signin">Sign in</a>
                <?php endif ?>
            </section>
        </nav>
    </div>