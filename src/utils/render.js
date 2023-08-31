const mainForm = document.querySelector('#myForm');
    mainForm.addEventListener('submit', function (e){
        e.preventDefault();
        const xVal = parseFloat(document.querySelector('#xValue').value);
        const rVal = parseFloat(document.querySelector('#rValue').value);

        const selector = document.querySelector('#ySelector');
        const yVal = parseFloat(selector.options[selector.selectedIndex].value);

        if (validate(xVal, rVal)){
            drawCoordsPlane(rVal);
            if (xVal > rVal || yVal > rVal || xVal < -rVal || yVal < -rVal){
                alert('Unable to draw a point, length of the axes exceeded')
            }
            const canvasCoords = toCanvasCoords(xVal, yVal, rVal, 350);
            drawPoint(canvasCoords.x, canvasCoords.y);
            fetch('count_values.php', {
                method: 'POST',
                body: new URLSearchParams({
                    xVal: xVal,
                    yVal: yVal,
                    rVal: rVal
                })
            })
                .then(response => response.text())
                .then(result => {
                    let responseData = JSON.parse(result);
                    addToTable(xVal, yVal, rVal, responseData.result, responseData.curr_time, responseData.exec_time);
                    saveToLocalStorage(xVal, yVal, rVal, responseData.result, responseData.curr_time, responseData.exec_time);
                });
        } else {
            alert("Error in inputted data, try again")
        }

    });
