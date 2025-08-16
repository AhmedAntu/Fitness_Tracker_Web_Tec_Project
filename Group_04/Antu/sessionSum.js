let sessions = [];
let notesError = document.getElementById('notesError');

function checkNotes(){
    let note = document.getElementById('notes').value;
    if(note.trim() === ""){
        notesError.innerHTML = "Please write some notes before saving.";
        notesError.style.color = 'red';
        return false;
    }else{
        notesError.innerHTML = "";
        return true;
    }
}

function saveSummary(){
    let ok = checkNotes();
    if(!ok){
        return false;
    }

    let note = document.getElementById('notes').value;
    sessions.push(note);
    displaySessions();
    document.getElementById('notes').value = "";
    return false;
}

function displaySessions(){
    let container = document.getElementById('sessionHistory');
    container.innerHTML = "";
    for(let i = 0; i < sessions.length; i++){
        let p = document.createElement('p');
        p.textContent = (i + 1) + ". " + sessions[i];
        container.appendChild(p);
    }
}
