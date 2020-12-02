import { UI } from '../ui';

export let tabs = {

    selector : '.ui-tabs',
    tabSelector : '.item--tab',
    tabContentSelector : '.tab__content',
    buttonSelector : '.do-toggle-tab',
    activeClass : 'tab--open',

    bind : function(selector = this.selector) {

        if( document.querySelector(selector) === null ) return;
        
        let tabContainer = document.querySelector(selector);

        //multiple containers: bind all buttons in document instead of one container only
        let buttons = document.querySelectorAll(this.buttonSelector);

        console.log(buttons);

        buttons.forEach( (button) => {

            button.addEventListener('click', (event) => {

                let target = event.target;
                let tab = target.closest(this.tabSelector);
                
                this.toggleTab(tab);                                

                event.preventDefault();

            });

        });

        //some tabs are open by default (via hardcoded open class in markup), but on mobile we want all tabs collapsed
        if( UI.windowWidth < 960 ) this.closeAllTabs(tabContainer);

    },

    toggleTab : function(tab) {

        let tabName = tab.dataset.tabName;
        let tabsContainer = tab.closest(this.selector);
        
        //target both tab nav item and tab content item via mutual selector
        let tabs = tabsContainer.querySelectorAll('[data-tab-name="'+tabName+'"]');

        //we don't want to allow multiple tabs to be opened at once
        //keep in mind this will prevent also from closing current tab - should you need to have all tabs collapsed, introduce "closeSiblings" method with current tab name param
        if(UI.windowWidth < 960) {
            this.closeAllTabs(tabsContainer, tab);
        } else {
            this.closeAllTabs(tabsContainer);
        }

        tabs.forEach(tab => {
            if( tab.classList.contains(this.activeClass) ) {
                this.closeTab(tab);
            } else {
                this.openTab(tab);
            }

        });

    },

    openTab : function(tab) {
        tab.classList.add(this.activeClass);
        tab.setAttribute('data-collapsed', 'false');
    },

    closeTab : function(tab) {
        tab.classList.remove(this.activeClass);
        tab.setAttribute('data-collapsed', 'true');
    },

    /**
     * Close all tabs
     * @currentTab {DOM el} - when provide - close all but current (sibligns only)
     */
    closeAllTabs : function(tabsContainer, currentTab = false) {

        let openedTabs = tabsContainer.querySelectorAll('.'+this.activeClass);
        let currentTabName;

        if(currentTab) {
            currentTabName = currentTab.dataset.tabName;
        }

        openedTabs.forEach(tab => {
            let tabName = tab.dataset.tabName;
            if(tabName !== currentTabName) this.closeTab(tab);

        });

    },
}
