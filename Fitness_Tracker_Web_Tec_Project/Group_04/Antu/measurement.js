let measurements = [];
let weightError = document.getElementById('weightError');
let waistError = document.getElementById('waistError');
let chestError = document.getElementById('chestError');

function checkWeight(){
    let value = parseFloat(document.getElementById('weight').value);
    if(isNaN(value) || value < 20 || value > 100){
        weightError.innerHTML = "Please enter weight between 20 to 100 kg!";
        weightError.style.color = 'red';
        return false;
    }else{
        weightError.innerHTML = "";
        return true;
    }
}

function checkWaist(){
    let raw = document.getElementById('waist').value;
    let value = parseFloat(raw);

    if(raw === ""){
        waistError.innerHTML = "Please enter waist between 20 to 100 cm.";
        waistError.style.color = 'red';
        return false;
    }else if(isNaN(value) || value < 20 || value > 100){
        waistError.innerHTML = "Please enter waist between 20 to 100 cm";
        waistError.style.color = 'red';
        return false;
    }else{
        waistError.innerHTML = "";
        return true;
    }
}

function checkChest(){
    let raw = document.getElementById('chest').value;
    let value = parseFloat(raw);

    if(raw === ""){
        chestError.innerHTML = "Please enter chest between 20 to 100 cm.";
        chestError.style.color = 'red';
        return false;
    }else if(isNaN(value) || value < 20 || value > 100){
        chestError.innerHTML = "Please enter chest between 20 to 100 cm";
        chestError.style.color = 'red';
        return false;
    }else{
        chestError.innerHTML = "";
        return true;
    }
}

function saveMeasurement(){
    let ok = checkWeight() && checkWaist() && checkChest();
    if(!ok){
        return false;
    }

    let weight = document.getElementById('weight').value;
    let waist = document.getElementById('waist').value;
    let chest = document.getElementById('chest').value;

    measurements.push({ weight: weight, waist: waist, chest: chest });
    displayMeasurements();

    document.getElementById('weight').value = "";
    document.getElementById('waist').value = "";
    document.getElementById('chest').value = "";

    return false;
}

function displayMeasurements(){
    let list = document.getElementById('measurementList');
    list.innerHTML = "";
    for(let i = 0; i < measurements.length; i++){
        let m = measurements[i];
        let li = document.createElement('li');
        li.textContent = "Weight: " + m.weight + " kg, Waist: " + m.waist + " cm, Chest: " + m.chest + " cm";
        list.appendChild(li);
    }
}
