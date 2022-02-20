function lookForBookByPublisher() {
    if("savedData" in localStorage) {
        document.getElementById("savedContent").innerHTML = decodeURI(localStorage.getItem("savedData"));
        localStorage.setItem("savedData", document.cookie.split(/=|;/)[1]);
    }
    else {
        document.getElementById("savedContent").innerHTML = "No saved content";
        localStorage.setItem("savedData", document.cookie.split(/=|;/)[1]);
    }
}