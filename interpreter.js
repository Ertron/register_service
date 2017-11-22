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
            /*{
                "step_id": "2",
                "parameters": 90
            }*/

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

let steps = {
    1 : {
        "param" : 30,
        "method" : function () {
            console.log('scrollTop method : ', window.scrollY);
            console.log('Method this : ', activeScenario);
            let finded = activeScenario.steps.filter(function( obj ) {
                return obj.step_id == activeScenario.id;
            });
            console.log('result : ', steps);
            if(window.scrollY > ((body.offsetHeight - window.innerHeight)/100 * finded[0].parameters)){
                alert('krasava!!!');
                steps[1].action_end(1);
            }
        },
        "action_start" : function (id) {
            console.log('action start id 1');
            window.addEventListener('scroll', steps[id].method);
        },
        "action_end" : function (id) {
            console.log('action end id 1 : ', id);
            window.removeEventListener('scroll', steps[id].method);
        }
    },
   /* 2 : {
        "param" : 2000,
        "method" : function () {
            console.error('Before setTimeout!');
            setTimeout(function() {
                console.error('setTimeout!');
            }, this.param);
        },
        "action_start" : function (id) {
            console.log('action start id 2');
        },
        "action_end" : function () {
            console.log('action end id 2');
        }
    },*/
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

var scenarioClass = (function (inc_steps, all_steps) {
    let scenario_id = '';
    let popup_id = '';

    let arrayOfActiveSteps = [];

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

    function activateSteps(){
        arrayOfActiveSteps.forEach(function (value) {
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
        console.log('arrayOfActiveSteps : ', arrayOfActiveSteps);
    }

    function initialize() {
        console.log('initialize : ', inc_steps);
        setScenarioId(inc_steps.id);
        setPopupId(inc_steps.popup_id);
        addSteps(inc_steps.steps, all_steps);
        activateSteps();

    }
    initialize();

    return {
        getScenarioId : getScenarioId,
        getPopupId : getPopupId
    }
});

let test = new scenarioClass(arrayScenarios[1], steps);
/*steps[1].action_start(1);
steps[1].method();*/

function setStep(step){

}
let xxx = setStep(steps[1]);
function scenario() {
    console.log('scrollTop : ', window.scrollY);
}

let ccc = 1;
let zzz = function () {
    steps[ccc].method();
};
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

