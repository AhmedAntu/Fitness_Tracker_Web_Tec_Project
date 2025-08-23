function checkExercise(){
    let value = document.getElementById('exercise').value;
    let exerciseError = document.getElementById('exerciseError');
    if(value === "" || value === null || value === undefined){
        exerciseError.innerHTML = "Please select an exercise!";
        exerciseError.style.color = 'red';
        return false;
    }else{
        exerciseError.innerHTML = "";
        return true;
    }
}

function checkSets(){
    let value = parseInt(document.getElementById('sets').value, 10);
    let setsError = document.getElementById('setsError');
    if(isNaN(value) || value <= 0){
        setsError.innerHTML = "Sets must be a positive number!";
        setsError.style.color = 'red';
        return false;
    }else{
        setsError.innerHTML = "";
        return true;
    }
}

function checkReps(){
    let value = parseInt(document.getElementById('reps').value, 10);
    let repsError = document.getElementById('repsError');
    if(isNaN(value) || value <= 0){
        repsError.innerHTML = "Reps must be a positive number!";
        repsError.style.color = 'red';
        return false;
    }else{
        repsError.innerHTML = "";
        return true;
    }
}

function checkWeight(){
    let raw = document.getElementById('weight').value;
    let weightError = document.getElementById('weightError');
    if(raw === "" || raw === null){
        weightError.innerHTML = ""; 
        return true;
    }
    let value = parseFloat(raw);
    if(isNaN(value) || value < 50){
        weightError.innerHTML = "Weight must be 50 or more.";
        weightError.style.color = 'red';
        return false;
    }else{
        weightError.innerHTML = "";
        return true;
    }
}

function logExercise(){
    let ok = checkExercise() && checkSets() && checkReps() && checkWeight();
    if(!ok){
        return false;
    }

    let exercise = document.getElementById('exercise').value;
    let sets = document.getElementById('sets').value;
    let reps = document.getElementById('reps').value;
    let weight = document.getElementById('weight').value;

    let list = document.getElementById('exerciseList');
    let item = document.createElement('li');
    let text = exercise + " - " + sets + " sets x " + reps + " reps";
    if(weight !== ""){
        text += " (" + weight + " kg)";
    }
    item.textContent = text;
    list.appendChild(item);

    document.getElementById('exercise').value = "";
    document.getElementById('sets').value = "";
    document.getElementById('reps').value = "";
    document.getElementById('weight').value = "";

    return false;
}
