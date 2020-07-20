var jsonElement = document.getElementById("json");

var content = jsonElement.innerHTML;

var json = JSON.parse(content);

var keys = Object.keys(json[0]);

var formatedContent = `<div><span class="squareBracket">[</span>`;


for (let index = 0; index < json.length; index++) {
    let formatedContentSingleObj = `<div>
        <span class="curlyBracket">{</span>`;

    let obj = json[index];
    for (let j = 0; j < keys.length; j++) {
        let key = keys[j];
        let value = obj[key];
        value = getSpanWithValue(value);


        formatedContentSingleObj += `
            <div>
                <span class="string"><span class="colon">"</span>${key}<span class="colon">"</span></span>
                <span class="colon">:</span>
                ${value}
                ${(j + 1 < keys.length) ? `<span class="colon">,</span>` : ""}
            </div>
        `

    }

    formatedContentSingleObj += `<span class="curlyBracket">}${(index + 1 < json.length) ? `<span class="colon">,</span>` : ""}</span></div>`;

    formatedContent += formatedContentSingleObj;
}

formatedContent += `<span class="squareBracket">]</span></div>`;
jsonElement.innerHTML = formatedContent;

function isObject(obj) {
    if (typeof obj === 'object') return true;
    else return false;
}

function getSpanWithValue(variable) {
    let type = typeof variable;

    let result = `<span class="`;

    switch (type) {
        case "number":
            result += `number">${variable}</span>`;
            break;
        case "boolean":
            result += `boolean">${variable}</span>`;
            break;
        case "object":
            result += `null">${variable}</span>`;
            break;
        default:
            result += `string"><span class="colon">"</span>${variable}<span class="colon">"</span></span>`;
            break;
    }

    return result;
}