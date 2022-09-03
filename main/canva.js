function _(selector){
    return document.querySelector(selector);
}

function setup(){
    let canvas = createCanvas(750, 700);
    canvas.parent("canvas-wrapper");
    background(255);
}

function get_data(){
    let type = _("#pen-pencil").checked?"pencil":"brush";
    let size = parseInt(_("#pen-size").value);
    let color = _("#pen-color").value;
    fill(color);
    stroke(color);

    return [type, size];
}

function mouseClicked(){
    let tmp = get_data();
    let type = tmp[0];
    let size = tmp[1];

    if (type == "brush"){
        ellipse(mouseX, mouseY, size, size);
    }
}

function mouseDragged(){
    let tmp = get_data();
    let type = tmp[0];
    let size = tmp[1];

    if (type == "pencil"){
        push();
        strokeWeight(size);
        line(pmouseX, pmouseY, mouseX, mouseY);
        pop();
    }
    else{
        ellipse(mouseX, mouseY, size, size);
    }
}

_("#reset-canvas").addEventListener("click",
    function(){
        if (confirm('Do you really want to reset your draw?')) {
            background(255);
        }
});

_("#save-canvas").addEventListener("click",
    function(){
        saveCanvas(canvas, "beautiful_draw", "png");
});

_("#upload-canvas").addEventListener("click",
    function(){
        if (confirm('Do you really want to upload your draw?')) {
            var data = canvas.toDataURL('image/png').replace(/data:image\/png;base64,/, '');

            $.ajax({
                url: "../database/functions.php",
                type: 'post',
                data: {
                    'send_img': 1,
                    'data' : data
                },
                success: function(response){
                    let button = document.getElementById("upload-canvas");
                    button.disabled = true;
                    button.title = "come back tomorow!";
                    console.log(">> ", response);
                }
            });
        }
});

