'use strict';

export default class Libs {

    removeChilds(myNode){
        while (myNode.firstChild) {
          myNode.removeChild(myNode.lastChild);
        }
    }
}

