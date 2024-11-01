<!DOCTYPE html>
<html>

<head>
    <title>Pratical :: Signal Light</title>
    <link href="<?= base_url("public/css/") ?>bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url("public/css/") ?>signal-light.css" rel="stylesheet">

    <script src="<?= base_url("public/js/jquery-min.js") ?>"></script>
    <script src="<?= base_url("public/js/additional-methods.min.js") ?>"></script>
    <script src="<?= base_url("public/js/jquery-validate.min.js") ?>"></script>
    <script src="<?= base_url("public/js/") ?>bootstrap.min.js"></script>
</head>

<body class="container w-50">
    <h1 class="text-center">Signal Light</h1>

    <form id="signal-light-form">
        <div id="alert-div" class="d-none"></div>
        <div class="row mb-3 text-center">
            <?php
            foreach ($data as $key => $val) {
            ?>
                <div class="col-3">
                    <label class="form-label"><?= $val['light_name'] ?></label>
                    <div id="light_<?= $val['light_sequence'] ?>" class="light <?= $val['light_sequence'] == 1  ? 'green' : 'red' ?>"></div>
                    <input type="hidden" name="id[<?= $key ?>]" value="<?= $val["id"] ?>" />
                    <input type="number" class="form-control" min="1" max="4" step="1" name="light[<?= $key ?>]" value="<?= $val['light_sequence'] ?>" />
                </div>

            <?php } ?>

        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label class="col-form-label">Green light interval</label>
            </div>
            <div class="col-6">
                <input type="number" class="form-control" name="green_interval" value="<?= $data[0]['green_interval'] ?>" min="1" max="180" step="1" placeholder="Enter seconds" />
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label class="col-form-label">Yellow light interval</label>
            </div>
            <div class="col-6">
                <input type="number" class="form-control" name="yellow_interval" value="<?= $data[0]['yellow_interval'] ?>" min="1" max="5" step="1" placeholder="Enter seconds" />
            </div>
        </div>

        <div class="text-center">
            <button class="px-5 btn btn-success" id="btn_start" type="submit">Start</button>
            <button class="px-5 btn btn-secondary" type="button" onclick="stopBtnClickHandler()">Stop</button>
        </div>
    </form>

    <script>
        let timers = [];
        let lightInputRule = {
            required: true,
            digits: true,
            min: 1,
            max: 4
        };

        $(document).ready(function() {
            $("#signal-light-form").validate({
                errorClass: "text-danger",
                rules: {
                    green_interval: {
                        required: true,
                        digits: true,
                        min: 1,
                        max: 180
                    },
                    yellow_interval: {
                        required: true,
                        digits: true,
                        min: 1,
                        max: 5
                    }
                },
                submitHandler: function(form) {
                    const formData = $(form).serialize();
                    stopSignal();

                    $.ajax({
                        url: "<?= site_url("signalLight/saveData") ?>",
                        method: "post",
                        dataType: "json",
                        data: formData,
                        beforeSend: function() {
                            $("#alert-div").addClass("d-none").empty();
                            $("#btn_start").attr("disabled", true);
                        },
                        complete: function() {
                            $("#btn_start").attr("disabled", false);
                        },
                        success: function(res) {
                            if (res.success === true) {
                                let {
                                    green_interval,
                                    yellow_interval,
                                    light,
                                } = res.data;
                                currentLight = 1;
                               
                                $(".light").each(function(index){
                                    $(this).attr('id', 'light_'+ light[index]);
                                });
                               
                                startSignal(light.length, currentLight, green_interval, yellow_interval);
                            } else {
                                showAlertMsg("danger", res.message);
                            }
                        }
                    });
                }
            });

            $("input[name^='light']").each(function() {
                $(this).rules("add", lightInputRule);
            });
        });

        function showAlertMsg(className, msg) {
            $("#alert-div").removeClass("d-none").html(`
            <div class="alert alert-${className} alert-dismissible fade show" role="alert">
                <strong>${msg}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            `);
        }

        function startSignal(totalLight, currentLight, greenInterval, yellowInterval) {
    
            let currentEle = $("#light_"+ currentLight);
            $(".light").removeClass("green yellow").addClass("red");

            // show yellow light
            currentEle.addClass("yellow").removeClass("red");
            

            timers.push(setTimeout(function(){
                // show green light after yellow interval
                currentEle.removeClass("yellow").addClass("green");

                timers.push(setTimeout(function(){
                    // Show yellow light after green light
                    currentEle.removeClass("green").addClass("yellow");

                    timers.push(setTimeout(function(){
                        // show red light after yellow light
                        currentEle.removeClass("yellow").addClass("red");

                      
                        let nextIndex = ((currentLight + 1) % totalLight);
                        if(currentLight === 3){
                            nextIndex = 4;
                        }else if(currentLight == 4){
                            nextIndex = 1;
                        }

                        currentLight = nextIndex;

                        startSignal(totalLight, currentLight, greenInterval, yellowInterval);
                    }, yellowInterval));
                }, greenInterval));
            }, yellowInterval));
        }

        function stopSignal(){
            timers.forEach(timerId => clearTimeout(timerId));
            timers = [];
        }

        function stopBtnClickHandler(){
            stopSignal();
            showAlertMsg("warning", "Signal stopped!");
        }
    </script>
</body>

</html>