let arrayScenarios = [
    {
        "id": "1",
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
        "id": "3",
        "popup_id": "1",
        "steps": [
            {
                "step_id": "1",
                "parameters": 10
            },
            {
                "step_id": "2",
                "parameters": 90
            }

        ]
    }
];
let activeScenario = {
    "id": "1",
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
};

function step_1(param) {
    // скролл на процент страницы
}

function step_2(param) {
    // таймаут
    // body.offsetHeight - window.innerHeight - SCROLLED TO 100%
}

function step_3() {
    // маусаут с браузера
}

let body = document.body;
let pageHeight = body.offsetHeight; // page height
let scrollTop = window.scrollY; // window scroll TOP Corner
let windowHeight = window.innerHeight; // window HEIGHT

function findIndexByParam(array, param_name, param_value) {
    let result;
    array.forEach(function (value, index) {
        if(value[param_name] == param_value){
            result = index;
            return;
        }
    });
    return result;
}

var scenarioClass = (function (inc_steps) {
    let scenario_id = '';
    let popup_id = '';
    let arrayOfActiveSteps = [];
    // default steps
    let steps = {
        1 : {
            "param" : 30,
            "method" : function () {
                console.log('scrollTop method : ', window.scrollY);
                console.log('Method this : ', activeScenario);
                let index = findIndexByParam(arrayOfActiveSteps, 'step_id', 1);
                console.log('result : ', steps);
                if(window.scrollY > ((body.offsetHeight - window.innerHeight)/100 * arrayOfActiveSteps[index].parameters)){
                    alert('krasava!!!');
                    console.log('arrayOfActiveSteps : ', arrayOfActiveSteps);
                    console.log('THOSE : ', index);
                    arrayOfActiveSteps[index].action_end(1, function () {
                        arrayOfActiveSteps[index].is_checked = true;
                        console.log('activateSteps : ', arrayOfActiveSteps);
                    });
                }
            },
            "action_start" : function (id) {
                console.log('action start id 1');
                window.addEventListener('scroll', steps[id].method);
            },
            "action_end" : function (id, callback) {
                console.log('action end id 1 : ', id);
                console.log('action end this : ', this);
                callback();
                window.removeEventListener('scroll', steps[id].method);
            }
        },
         2 : {
             "param" : 2000,
             "method" : function () {
                 console.error('Before setTimeout!');
                 setTimeout(function() {
                     console.error('setTimeout!');
                 }, this.param);
             },
             "action_start" : function () {
                 console.log('action start id 2');
                 let index = findIndexByParam(arrayOfActiveSteps, 'step_id', 2);
                 /*arrayOfActiveSteps[index] = */
             },
             "action_end" : function () {
                 console.log('action end id 2');
             }
         },
    };

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
            value.action_start(value.step_id);
        });
    }

    function addSteps(object, steps) {
        object.forEach(function (value, index) {
            arrayOfActiveSteps.push({
                'step_id' : value.step_id,
                'parameters' : value.parameters,
                'is_checked' : false,
                'method' : steps[1].method,
                'action_start' : steps[value.step_id].action_start,
                'action_end' : steps[value.step_id].action_end
            });
        });
    }

    function initialize() {
        console.log('initialize : ', inc_steps);
        setScenarioId(inc_steps.id);
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

let test = new scenarioClass(arrayScenarios[1]);
/*steps[1].action_start(1);
steps[1].method();*/

function addEvent(action, id){
    window.addEventListener(action, zzz);
}
function removeEvent(action, id){
    setTimeout(function () {
        console.error('rhaaaaa!');
        window.removeEventListener(action, zzz);
        /*alert('after 5 sec');*/
    }, 5000);
}

/*addEvent('scroll', 1);
removeEvent('scroll', 1);*/


