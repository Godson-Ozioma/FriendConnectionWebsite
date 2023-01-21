class WebRequest{
    #x = new XMLHttpRequest();
    constructor(){}

    print(){
        console.log("Class connected successfully");
    }

    //method for success and failure
    isValid(){
        return this.#x.readyState == 4 && this.#x.status == 200;
    }

    // open(method, url, async){
    //     this.#x.open(method, url, async);
    // }
    // send(body){
    //     return this.#x.send(body);
    // }


    getOnReadyStateChange(){
        return this.#x.onreadystatechange;
    }

    getXMLHttpRequest(){
        return this.#x;
    }
}