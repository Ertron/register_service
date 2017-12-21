let arrayScenarios = [
    {
        "scenario_id": "1",
        "popup_id": "1",
        "steps": [
            {
                "step_id": "1",
                "parameters": 10
            },
            {
                "step_id": "2",
                "parameters": 50
            }
        ]
    },
    {
        "scenario_id": "3",
        "popup_id": "1",
        "steps": [
            {
                "step_id": "1",
                "parameters": 80
            },
            {
                "step_id": "2",
                "parameters": 9000
            },
        ]
    }
];


function findIndexByParam(array, param_name, param_value) {
    let result;
    array.forEach(function (value, index) {
        if(value[param_name] == param_value){
            result = index;
            return result;
        }
    });
    return result;
}

var event = new MouseEvent('open', {
    'view': window,
    'bubbles': true,
    'cancelable': true
});

var scenarioClass = (function (inc_steps) {
    let scenario_id = '';
    let popup_id = '';
    let arrayOfActiveSteps = [];
    let show_popup = true;
    // default steps
    let steps = {
        1 : {
            "param" : 30,
            "method" : function (step_id) {
                console.log('scrollTop method : ', window.scrollY);
                function watcher() {
                    let index = findIndexByParam(arrayOfActiveSteps, 'step_id', step_id);
                    let body = document.body;
                    if(window.scrollY > ((body.offsetHeight - window.innerHeight)/100 * arrayOfActiveSteps[index].parameters)){
                        console.error('krasava!!!');
                        console.log('arrayOfActiveSteps : ', arrayOfActiveSteps);
                        console.log('THOSE : ', index);
                        arrayOfActiveSteps[index].is_checked = true;
                        console.log('activateSteps : ', arrayOfActiveSteps);
                        window.removeEventListener('scroll', watcher);
                        showPopup();
                    }
                }
                window.addEventListener('scroll', watcher);
            },
        },
         2 : {
             "param" : 2000,
             "method" : function (step_id) {
                 console.error('Before setTimeout!');
                 let index = findIndexByParam(arrayOfActiveSteps, 'step_id', step_id);
                 setTimeout(function() {
                     arrayOfActiveSteps[index].is_checked = true;
                     console.error('setTimeout! : ', arrayOfActiveSteps);
                     showPopup();
                 }, arrayOfActiveSteps[index].parameters);
             },
         },
        3 : {
            "param" : 0,
            "method" : function () {
                console.log('active Step 3');
                /*window.onbeforeunload = function(){
                    myfun();
                    return 'Are you sure you want to leave?';
                };*/
                function watcher() {
                    alert('STOP!');
                    console.log('watcher');
                    window.removeEventListener('mouseout', watcher);
                    emergencyStepCheck();
                    showPopup();
                }
                window.addEventListener('mouseout', watcher);
            }
        }
    };

    function allStepsChecked() {
        function isChecked(item) {
            return item.is_checked === true;
        }
        console.log('allStepsChecked : ', arrayOfActiveSteps.every(isChecked));
        return arrayOfActiveSteps.every(isChecked);
    }

    function emergencyStepCheck() {
        arrayOfActiveSteps.forEach(function (value, index) {
            arrayOfActiveSteps[index].is_checked = true;
        });
    }

    function showPopup() {
        if(allStepsChecked() && show_popup){
            console.info('ALL CHECKED');
            show_popup = false;
            let btn = document.querySelector('#rstbox_'+popup_id);
            btn.dispatchEvent(event);
            alert('POPUP');
        }
        else{
            console.info('NOT ALL CHECKED');
        }
    }

    function setScenarioId(id) {
        scenario_id = id;
    }
    function getScenarioId() {
        return scenario_id;
    }

    function setPopupId(id) {
        popup_id = id;
    }
    function getPopupId() {
        return popup_id;
    }
    
    function getActiveSteps() {
        return arrayOfActiveSteps;
    }

    function activateSteps(){
        arrayOfActiveSteps.forEach(function (value, index) {
            value.method(value.step_id);
        });
    }

    function addSteps(object, steps) {
        object.forEach(function (value, index) {
            console.log('value : ', value);
            console.log('steps : ', steps);
            arrayOfActiveSteps.push({
                'step_id' : value.step_id,
                'parameters' : value.parameters,
                'is_checked' : false,
                'method' : steps[value.step_id].method,/*
                'action_start' : steps[value.step_id].action_start,
                'action_end' : steps[value.step_id].action_end*/
            });
        });
    }

    function initialize() {
        console.log('initialize : ', inc_steps);
        setScenarioId(inc_steps.scenario_id);
        setPopupId(inc_steps.popup_id);

        addSteps(inc_steps.steps, steps);
        activateSteps();

    }
    initialize();

    return {
        getScenarioId : getScenarioId,
        getPopupId : getPopupId,
        getActiveSteps : getActiveSteps
    }
});

let scenario = arrayScenarios[1];

function startApp() {

    var XHR = ("onload" in new XMLHttpRequest()) ? XMLHttpRequest : XDomainRequest;

    var xhr = new XHR();
    /*var json = JSON.stringify({
        host : "optimization5.guide"
    });*/
    /*var json = JSON.stringify({
        popup_id: "33",
        steps: [
            {
                "step_id": "1",
                "parameters": {
                    "param1": "77",
                    "param2": "54"
                    }
            },
            {
                "step_id": "2",
                "parameters": {
                    "param1": "1",
                    "param2": "2"
                }
            }],
        filters: {
            "geo": {},
            "device": {},
            "time_table": {},
            "user_access": {"new" : 0, "old" : 1}
        }
    });*/

    /*xhr.open('POST', 'api/adminp/6/page/3/scenario', true);*/
    xhr.open('GET', 'http://magic.com/', true);

    xhr.onload = function() {
        console.log('onload : ', this.response);
        scenario = JSON.parse(this.response);
        let startScenario = new scenarioClass(scenario);
    };

    xhr.onerror = function() {
        alert( 'Ошибка ' + this.status );
        let startScenario = new scenarioClass(scenario);
    };

    xhr.send();

}
startApp();

