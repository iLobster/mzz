function addElementToList(name, links, id, elm_id)
{
    var elms = $(id).select('tr > td.toolbarBorder > strong');
    var addBefore = findBottomElement(elms, name);

    var trTitle = new Element('tr', {className: 'toolbarTitle', onmouseover: 'this.style.backgroundColor = HOVER_BG_COLOR', onmouseout: 'this.style.backgroundColor = TITLE_BG_COLOR'});
    var tdActions = new Element('td', {className: 'toolbarActions'});

    convertLinkToHtml(links, tdActions);

    trTitle.insert(
        new Element('td', {className: 'toolbarBorder'}).insert(
            new Element('strong').update(name)
        ).insert(
            new Element('span', {className: "newlySubjectNotice"}).update('(new)')
        )
    );

    trTitle.insert(tdActions);
    if (elm_id) {
        trTitle = new Element('tbody').insert(trTitle);
    }

    var trClasses = new Element('tr', {onmouseover: 'this.style.backgroundColor = HOVER_BG_COLOR', onmouseout: 'this.style.backgroundColor = SECOND_BG_COLOR'}).insert(
        new Element('td', {colspan: 2, className: "toolbarElementName toolbarEmpty"}).update('--- классов нет ---')
    );

    if (elm_id) {
        _trClasses = trClasses;
        trClasses = new Element('tbody', {id: elm_id}).insert(_trClasses);
    }

    if (addBefore === true) {
        $(id).insert({bottom: trTitle}).insert({bottom: trClasses});
    } else {
        addBefore.up(elm_id ? 'tbody' : 'tr.toolbarTitle').insert({before: trTitle}).insert({before: trClasses});
    }
    buildJipLinks();
}

function addClassToModule(name, module, links)
{
    var elms = $('module-' + module + '-classes').select('tr > td > span.className');
    var addBefore = findBottomElement(elms, name);

    var tr = new Element('tr', {onmouseover: 'this.style.backgroundColor = HOVER_BG_COLOR', onmouseout: 'this.style.backgroundColor = SECOND_BG_COLOR'});
    var td =  new Element('td', {className: "toolbarElementName", colspan: 2});

    convertLinkToHtml(links, td);

    td.insert(new Element('span', {className: "className"}).update(name)).insert(
            new Element('span', {className: "newlySubjectNotice"}).update('(new)')
        );

    tr.insert(td);

    if (addBefore === true) {
         $('module-' + module + '-classes').insert(tr);
    } else if (!addBefore) {
         $('module-' + module + '-classes').insert(tr).down('tr').remove();
    } else {
        addBefore.up('tr').insert({before: tr});
    }
    buildJipLinks();
}

function findBottomElement(elms, name)
{
    var l = $A(elms).size();
    var addBefore = elms.first();
    for (var i=0; i < l; i++) {
        var neighbours = [elms[i], elms[i+1]];
        if (neighbours[0].innerHTML < name && neighbours[1] && neighbours[1].innerHTML > name) {
            addBefore = neighbours[1];
            break;
        }

        if (i == l - 1 && (neighbours[0] && neighbours[0].innerHTML < name)) {
            addBefore = true;
        }
    }
    return addBefore;
}

function convertLinkToHtml(links, td)
{
   links.each(function(url) {
        url = $H(url);
        td.insert(new Element('a', {href: url.get('url'), className: "jipLink"}).insert(
        new Element('img', {src: SITE_PATH + "/templates/images/" + url.get('img'), alt: url.get('alt'), title: url.get('alt')})
        ));
    });
}