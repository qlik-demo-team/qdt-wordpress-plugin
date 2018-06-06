console.log(1);
console.log(vars);
console.log(atts);

var qConfig = {
    "config": {
        "host": vars.qdt_host,
        "secure": (vars.qdt_secure==="1") ? true : false,
        "port": parseInt(vars.qdt_port),
        "prefix": vars.qdt_prefix,
        "appId": vars.qdt_appId
    },
    "connections": { 
        "vizApi": true, 
        "engineApi": false 
    }
}
console.log(qConfig);
var QdtComponent = new window.QdtComponents(qConfig.config, qConfig.connections);
var element = document.getElementById('qdt_'+atts.id);
if (atts.type==='QdtViz' && atts.id) {
    QdtComponent.render('QdtViz', {id: atts.id, height: '400px'}, element);
}