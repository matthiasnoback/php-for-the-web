<?php

include(__DIR__ . '/functions/tour-crud.php');

include(__DIR__ . '/../bootstrap.php');

if (!isset($_GET['id'])) {
    header('Location: /list-tours');
    exit;
}

$tourId = (int)$_GET['id'];
$tourData = load_tour_data($tourId);

include(__DIR__ . '/../_header.php');

?>
<p><a href="/list-tours">Back to the list</a></p>
<p><a href="/edit-tour?id=<?php echo $tourId; ?>" class="btn btn-primary">Edit this tour</a></p>
<h1>Tour to <?php
    echo htmlspecialchars($tourData['destination'], ENT_QUOTES);
?></h1>
<?php
if (isset($tourData['picture'])) {
    ?>
    <p>
        <img src="/uploads/<?php
            echo htmlspecialchars($tourData['picture'], ENT_QUOTES);
        ?>" alt="Illustration">
    </p>
    <?php
}
?>
<p>This tour is <?php echo $tourData['is_accessible']
    ? 'accessible'
    : 'not accessible'; ?>.</p>
<p>There are <?php
    echo htmlspecialchars($tourData['number_of_tickets_available'], ENT_QUOTES);
?> tickets available.</p>
<?php

include(__DIR__ . '/../_footer.php');
