$(document).on("click", ".keep-open", function (e) {
    e.stopPropagation();
});

$(document).on("click", ".print", function () {
    window.print();

    // var style = css($("#controlpanelbody"));

    // var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    // mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    // mywindow.document.write('</head><body >');
    // mywindow.document.write('<h1>' + document.title  + '</h1>');
    // mywindow.document.write($("#controlpanelbody").html());
    // mywindow.document.write("<style>");
    // mywindow.document.write(style);
    // mywindow.document.write("</style>");
    // mywindow.document.write('</body></html>');

    // mywindow.document.close(); // necessary for IE >= 10
    // mywindow.focus(); // necessary for IE >= 10*/

    // mywindow.print();
    // mywindow.close();
});
function css(a) {
    var sheets = document.styleSheets, o = {};
    for (var i in sheets) {
        var rules = sheets[i].rules || sheets[i].cssRules;
        for (var r in rules) {
            if (a.is(rules[r].selectorText)) {
                o = $.extend(o, css2json(rules[r].style), css2json(a.attr('style')));
            }
        }
    }
    return o;
}

function css2json(css) {
    var s = {};
    if (!css) return s;
    if (css instanceof CSSStyleDeclaration) {
        for (var i in css) {
            if ((css[i]).toLowerCase) {
                s[(css[i]).toLowerCase()] = (css[css[i]]);
            }
        }
    } else if (typeof css == "string") {
        css = css.split("; ");
        for (var i in css) {
            var l = css[i].split(": ");
            s[l[0].toLowerCase()] = (l[1]);
        }
    }
    return s;
}

var palavra = ''
var isDarkMode = false;
$(document).keydown(function (event) {
    var key = (event.keyCode ? event.keyCode : event.which);
    let word = String.fromCharCode(key);
    switch (key) {
        case 115: //f4
            $('#sm-modal_pdv').modal('toggle');
            break;
        case 117: //f6
            palavra = '';
            break;
        // case 13: //f4
        //     document.getElementById("keyenter").click(); // Click on the checkbox
        //     break;

        default:
            theme(word);
            break;
    }

});
function theme(str) {
    palavra = palavra + str;
    if (palavra == 'DARKMODE') {
        console.log(palavra);
        palavra = "";
        if (!isDarkMode) {
            loadCSS('../assets/css/theme-dark-full.min.css');
            isDarkMode = true;
        }
    }
    if (palavra.length == 8) {
        palavra = '';
    }
}
function loadCSS(url) {
    // Get HTML head element 
    var head = document.getElementsByTagName('HEAD')[0];

    // Create new link Element 
    var link = document.createElement('link');
    // set the attributes for link element  
    link.rel = 'stylesheet';
    link.type = 'text/css';
    link.href = url;
    // Append link element to HTML head 
    head.appendChild(link);
}