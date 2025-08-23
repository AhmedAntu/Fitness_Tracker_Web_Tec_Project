let notesError = document.getElementById('notesError');
let notesInput = document.getElementById('notes');
let sessions = JSON.parse(localStorage.getItem('sessionNotes') || "[]");

function validateNotes() {
    let val = notesInput.value.trim();
    if(val === ""){
        notesError.textContent = "Notes cannot be empty!";
        notesError.style.color = 'red';
        return false;
    } else {
        notesError.textContent = "";
        return true;
    }
}

function saveSession() {
    if(!validateNotes()) return false;

    let note = notesInput.value.trim();
    sessions.push({
        note,
        timestamp: new Date().toISOString()
    });
    localStorage.setItem('sessionNotes', JSON.stringify(sessions));
    displaySessions();

    notesInput.value = "";
    return false;
}

function displaySessions() {
    let list = document.getElementById('sessionList');
    list.innerHTML = "";

    sessions.forEach((session, i) => {
        let li = document.createElement('li');
        let date = new Date(session.timestamp);
        let dateString = date.toLocaleString();
        li.textContent = `[${dateString}] ${session.note}`;

        let delBtn = document.createElement('button');
        delBtn.textContent = "Delete";
        delBtn.style.marginLeft = "20px";
        delBtn.onclick = () => {
            sessions.splice(i,1);
            localStorage.setItem('sessionNotes', JSON.stringify(sessions));
            displaySessions();
        };
        li.appendChild(delBtn);
        list.appendChild(li);
    });
}

function filterSessions() {
    let filter = document.getElementById('sessionSearch').value.toLowerCase();
    let list = document.getElementById('sessionList');
    let items = list.getElementsByTagName('li');

    for(let i=0; i<items.length; i++){
        let txt = items[i].textContent || items[i].innerText;
        items[i].style.display = txt.toLowerCase().indexOf(filter) > -1 ? "" : "none";
    }
}

displaySessions();
