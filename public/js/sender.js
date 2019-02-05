var sender = {};

sender.getFormData = function(target, formData = new FormData()) {
    if (typeof target === 'string') {
        target = document.querySelector(target);
    }

    for (var child of target) {
        formData.append(child.name, child.value);
    }

    return formData;
}

sender.sendForm = function(target, url) {
    var data = sender.getFormData(target);

    return fetch(url, {
        method: 'POST',
        body: data,

        // Pro laravel saber que é uma request
        // por js
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    });
}