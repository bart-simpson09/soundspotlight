let defaultTab = document.getElementById("defaultTab");
if (defaultTab != null) {
    defaultTab.click();
}

function openTab(event, tabName) {
    let i, tabContent, tabItem;

    tabContent = document.getElementsByClassName("tabContent");
    for (i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = "none";
    }

    tabItem = document.getElementsByClassName("tabItem");
    for (i = 0; i < tabItem.length; i++) {
        tabItem[i].className = tabItem[i].className.replace(" active", "");
    }

    document.getElementById(tabName).style.display = "flex";
    event.currentTarget.className += " active";
}