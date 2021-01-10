const VAPID_PUBLIC_KEY = "BPZTwlFufPeNhwWk5-_7th0rRxGdtFV2D32Id-MR42Egggvx5jl759xoE_cHhAs0XSJdLOojhdPSl1OrHuLt0Uo";
// const urlBase = 'http://localhost:8000/';
const urlBase = 'http://192.168.1.21/';

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

/*
    Función que se encarga de las suscripciones para permitir las notificaciones.
*/
const suscription = async () => {
    //Service Worker
    const register = navigator.serviceWorker.register('/worker.js', {
        scope: '/'
    });
    console.log("New service worker");

    const dataSubscription = (await register).pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: urlBase64ToUint8Array(VAPID_PUBLIC_KEY),
    });

    const convertJSON = JSON.stringify(await (dataSubscription));
    const data = JSON.parse(convertJSON);

    const body = {
        dataSuscription: data,
        /*title: 'Titulo',
        message: 'mensaje'*/
    }
    // console.log(body)

    await fetch(urlBase + 'api/suscribe/', {
        method: 'POST',
        body: JSON.stringify(body),
        mode: 'cors',
        cache: 'default',
        headers: {
            'Content-Type': 'application/json',
        }
    });
    console.log("Suscribed");
}

suscription();
