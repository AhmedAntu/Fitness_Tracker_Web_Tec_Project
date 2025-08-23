let photoError = document.getElementById('photoError');

function addPhoto(){
    let fileInput = document.getElementById('photo');
    let file = null;

    if(fileInput && fileInput.files && fileInput.files.length > 0){
        file = fileInput.files[0];
    }

    if(!file){
        photoError.innerHTML = "Please select a photo before adding.";
        photoError.style.color = 'red';
        return false;
    }else{
        photoError.innerHTML = "";
    }

    if(!(file.type && file.type.indexOf('image/') === 0)){
        photoError.innerHTML = "Selected file is not an image.";
        photoError.style.color = 'red';
        fileInput.value = '';
        return false;
    }else{
        photoError.innerHTML = "";
    }

    let reader = new FileReader();
    reader.onload = function(e){
        let img = document.createElement('img');
        img.src = e.target.result;
        img.style.width = "150px";
        img.style.margin = "10px";
        let gallery = document.getElementById('photoGallery');
        gallery.appendChild(img);
    };
    reader.readAsDataURL(file);

    fileInput.value = '';
    return false;
}
