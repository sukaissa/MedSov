<?php
    $meeting_id = $_GET["id"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedSov Telehealth</title>
</head>
<body>
    <div style="height: 800px !important ;">
        <!-- <iframe allow="camera; microphone; fullscreen; display-capture; autoplay" src="https://meet.jit.si/moderated/4d1fb6ec5602b24af983731bbcd016f8ea1668b7feb1b10e5edfab3534b1d487" style="height: 100%; width: 100%; border: 0px;"></iframe> -->
        <iframe allow="camera; microphone; fullscreen; display-capture; autoplay" src="<?php echo $meeting_id; ?>" style="height: 100%!important; width: 100%; border: 0px;"></iframe>
    </div>
</body>
</html>