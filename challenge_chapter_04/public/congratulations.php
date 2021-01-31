<?php

$availableLanguages = [
    'en' => 'English',
    'nl' => 'Nederlands',
    'de' => 'Deutsch'
];

// Default language: en
$defaultLanguage = 'en';

$selectedLanguage = $defaultLanguage;

if (isset($_GET['language'])) {
    // If the user selected a language, use it
    $selectedLanguage = $_GET['language'];
} elseif (isset($_COOKIE['language'])) {
    // If the language is stored as a cookie, use it
    $selectedLanguage = $_COOKIE['language'];
}

// If the language doesn't actually exist, use the default language
if (!isset($availableLanguages[$selectedLanguage])) {
    $selectedLanguage = $defaultLanguage;
}

setcookie('language', $selectedLanguage);

$messages = [
    'en' => 'Congratulations!',
    'nl' => 'Gefeliciteerd!',
    'de' => 'Gratuliere!'
]
?>
<!DOCTYPE html>
<html>
<head>
    <title>Congratulations</title>
</head>
<body>
<form method="get">
    <p>
        <label for="language">Language:</label>
        <select id="language" name="language">
            <?php
            foreach ($availableLanguages as $key => $value) {
                ?>
                <option value="<?php echo htmlspecialchars($key, ENT_QUOTES); ?>"
                    <?php if ($selectedLanguage === $key) { ?> selected<?php } ?>>
                    <?php echo htmlspecialchars($value, ENT_QUOTES); ?>
                </option>
                <?php
            }
            ?>
        </select>
    </p>
    <p>
        <button type="submit">Submit</button>
    </p>
</form>
<p class="message">
    <?php echo $messages[$selectedLanguage]; ?>
</p>
</body>
</html>
