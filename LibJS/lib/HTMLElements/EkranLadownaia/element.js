function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
export async function wlaczEkranLadowania(i) {
    let kontener = document.getElementById("LoadingScreen")
    let body=document.querySelector(".body1").innerHTML
    document.querySelector(".body1").innerHTML=""
    let inner = '<link rel="stylesheet" href="../../lib/HTMLElements/EkranLadownaia/elStyle.css">'
    inner+='<div class="loader"></div>'
    kontener.innerHTML=inner
    await sleep(i)
    kontener.innerHTML=""
    document.querySelector(".body1").innerHTML=body
}