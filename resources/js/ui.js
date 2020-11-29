import { tabs } from './ui/tabs';

export let UI = {

    mobile : /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent),
    windowWidth : null,
    windowHeight : null,
    debug : true,

    // calculate and store viewport dimensions
    // this method will be bound to window resize event so try not to overload it
    init : function() {

        this.windowWidth = window.innerWidth;
        this.windowHeight = window.innerHeight;

        if(this.debug) 
        console.log( 'Window width: '+this.windowWidth+ ', Window height: '+this.windowHeight );	

    },
    
    tabs,
}
