<!DOCTYPE html>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css">
<!-- Optional theme -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<title>Monster Hunter 3U Calculator</title>
</head>
<body>
<fieldset>
    <legend>Monster Hunter Damage Calculator</legend>
    <label>Attack Damage:&nbsp;&nbsp;&nbsp;
        <input id="attackdamage" type="text" placeholder=""></label><br>
    <label>Element Damage:
        <input id="elementdamage" type="text" placeholder=""></label>
    <label>Element Type:
        <select id="elementtype" class="form-control" style="width:200px" disabled="true">
            <option selected="selected"></option>
        </select></label><br>
    <label>Weapon:
        <select id="weapon" class="form-control" style="width:200px">
            <option selected="selected"></option>
        </select>
    </label>
    <label>Attack:
        <select id="attack" class="form-control" style="width:200px" disabled="true">
        </select>
    </label>
    <label>Sharpness:
        <select id="sharpness" class="form-control" style="width:200px">
            <option selected="selected"></option>
        </select>
    </label>
    <br>
    <label>Monster:
        <select id="monster" class="form-control" style="width:200px">
            <option selected="selected"></option>
        </select>
    </label>
    <label>Hit Zone:
        <select id="zone" class="form-control" style="width:200px" disabled="true">
            <option selected="selected"></option>
        </select>
    </label>
    <!-- <label>Quest Type:
        <select id="quest" class="form-control" style="width:200px">
            <option selected="selected"></option>
        </select>
    </label> -->
    <br>
    <button id="calculate" type="submit" class="btn">Calculate</button>
</fieldset>
<br>

<div id="results"></div>

<script>

    $(document).ready(function () {

        $.ajax({
            url: "scripts/import.php",
            type: 'post',
            success: function (data) {
                importData = JSON.parse(data);

                for (i = 0; i < importData['elements'].length; ++i) {
                    $("#elementtype").append($("<option></option>").text(importData['elements'][i]));
                }

                for (i = 0; i < importData['weapons'].length; ++i) {
                    $("#weapon").append($("<option></option>").text(importData['weapons'][i]));
                }

                for (i = 0; i < importData['sharpness'].length; ++i) {
                    $("#sharpness").append($("<option></option>").text(importData['sharpness'][i]));
                }

                for (i = 0; i < importData['monsters'].length; ++i) {
                    $("#monster").append($("<option></option>").text(importData['monsters'][i]));
                }

                for (i = 0; i < importData['quests'].length; ++i) {
                    $("#quest").append($("<option></option>").text(importData['quests'][i]));
                }
            }

        });

    });


    $("#calculate").click(function () {
        var formData = {
            'attackDamage': $('#attackdamage').val(),
            'elementDamage': $('#elementdamage').val(),
            'elementType': $('#elementtype').val(),
            'weapon': $('#weapon').val(),
            'attack': $('#attack').val(),
            'sharpness': $('#sharpness').val(),
            'monster': $('#monster').val(),
            'quest': $('#quest').val(),
            'zone': $('#zone').val()
        }

        $.ajax({
            url: "scripts/calculate.php",
            type: 'post',
            data: formData,
            success: function (data) {
                data = JSON.parse(data);
                $("#results").html("Raw Damage: " + data['raw'] +"<br>" + "Element Damage: " + data['element'] +"<br>" + "Total Damage: " + (data['raw'] + data['element']) +"<br>");
            }

        });
    });

    $("#weapon").change(function () {
        var weaponType = {
            'type': $('#weapon').val()
        }

        $.ajax({
            url: "scripts/attacks.php",
            type: 'post',
            data: weaponType,
            success: function (attacks) {
                $("#attack").empty();
                $("#attack").prop('disabled', false);
                attacks = JSON.parse(attacks);
                for (i = 0; i < attacks.length; ++i) {
                    $("#attack").append($("<option></option>").text(attacks[i]));
                }
            }
        });


    });

    $("#monster").change(function () {
        var monster = {
            'monster': $('#monster').val()
        }

        $.ajax({
            url: "scripts/zones.php",
            type: 'post',
            data: monster,
            success: function (zones) {
                $("#zone").empty();
                $("#zone").prop('disabled', false);
                zones = JSON.parse(zones);
                for (i = 0; i < zones.length; ++i) {
                    $("#zone").append($("<option></option>").text(zones[i]));
                }
            }
        });


    });

    $("#elementdamage").on('input', function () {
        if ($("#elementdamage").val().length == 0) {
            $("#elementtype").prop('disabled', true);
        }
        else {
            $("#elementtype").prop('disabled', false);
        }
    });
</script>
</body>
</html>
