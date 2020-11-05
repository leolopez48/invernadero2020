const url = 'http://localhost:8000/api/stations/';
const urlBase = 'http://localhost:8000/';
export default class Libs {


    removeChilds(myNode) {
        while (myNode.firstChild) {
            myNode.removeChild(myNode.lastChild);
        }
    }

    closeLoader() {
        document.getElementById('loader').style.display = 'none';
        document.getElementById('loader-toggle').classList.remove('active');
    }

    openLoader() {
        document.getElementById('loader-toggle').classList.add('active');
    }

    loadPreview(ev) {
        let preview = document.getElementById('inPhotoPre');
        let file = document.getElementById('inFile');
        preview.src = URL.createObjectURL(ev.target.files[0]);
        preview.onload = function () {
            URL.revokeObjectURL(preview.src) // free memory
        }
    }

    message(title, message, icon) {
        Swal.fire(
            title,
            message,
            icon
        );
    }

    resetForm() {
        document.getElementById('inPhotoPre').src = `${urlBase}default/no-image.png`;
        document.getElementById('inPhotoPre').value = "";

        document.getElementById('inFile').value = "";
        document.getElementById('inName').value = "";
        document.getElementById('inDescription').value = "";

        document.getElementById('inLowestPH').value = "";
        document.getElementById('inLowestPT').value = "";
        document.getElementById('inLowestPR').value = "";
        const users = document.getElementById('divUserAllowed');
        this.removeChilds(users);
        document.getElementById('divSearch').style.display = 'none';
    }

    hideByAccess() {
        document.getElementById('btnNewDiv').style.display = 'none';
    }

    cleanDivStations() {
        const divStations = document.getElementById('divStations');
        this.removeChilds(divStations);
    }
}
