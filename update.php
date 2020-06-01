<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the point id exists, for example update.php?id=1 will get the point with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $lat = isset($_POST['lat']) ? $_POST['lat'] : '';
        $lon = isset($_POST['lon']) ? $_POST['lon'] : '';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $datum = isset($_POST['datum']) ? $_POST['datum'] : date('Y-m-d');
        // Update the record
        $stmt = $pdo->prepare('UPDATE points SET id = ?, lat = ?, lon = ?, name = ?,datum = ? WHERE id = ?');
        $stmt->execute([$id, $lat, $lon, $name, $datum, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the point from the points table
    $stmt = $pdo->prepare('SELECT * FROM points WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $point = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$point) {
        exit('Point doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
    <h2>Update point #<?=$point['id']?></h2>
    <form action="update.php?id=<?=$point['id']?>" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" placeholder="1" value="<?=$point['id']?>" id="id">   

        <label for="lat">lat</label>
        <input type="text" name="lat" placeholder="John Doe" value="<?=$point['lat']?>" id="lat">

        <label for="lon">lon</label>
        <input type="text" name="lon" placeholder="johndoe@example.com" value="<?=$point['lon']?>" id="lon">

        <label for="name">name</label>
        <input type="text" name="name" placeholder="2025550143" value="<?=$point['name']?>" id="name">

        <label for="datum">Date</label>
        <input type="date" name="datum" value="<?=date('Y-m-d', strtotime($point['datum']))?>" id="datum">

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>