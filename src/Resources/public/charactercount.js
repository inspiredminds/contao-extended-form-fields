(function(){
    'use strict';

    document.querySelectorAll('textarea[data-add-counter]').forEach((textarea) => {
        const counter = document.createElement('span');
        counter.classList.add('character-counter__count');
        counter.innerHTML = '0';

        const wrapper = document.createElement('div');
        wrapper.classList.add('character-counter');
        wrapper.appendChild(counter);
        
        if (textarea.hasAttribute('maxlength')) {
            const separator = document.createElement('span');
            separator.classList.add('character-counter__separator');
            separator.innerHTML = '/';

            const maxlength = document.createElement('span');
            maxlength.classList.add('character-counter__maxlength');
            maxlength.innerHTML = textarea.getAttribute('maxlength');

            wrapper.appendChild(separator);
            wrapper.appendChild(maxlength);
        }

        textarea.parentNode.insertBefore(wrapper, textarea.nextSibling);

        textarea.addEventListener('input', () => {
            counter.innerHTML = textarea.value.length;
        });
    });
})();
