/**
 * HighlightJS script on frontend
 */
document.addEventListener('DOMContentLoaded', e => {
   document.querySelectorAll('.wp-block-highlight-js pre code').forEach((block) => {
      hljs.highlightBlock(block);
      if( block.dataset.showLineNumbers ) {
         // Multi line comments
         const regex = new RegExp('<span class="hljs-comment">(.|\n)*?</span>', 'g');
         block.innerHTML = block.innerHTML.replace(regex, data => {
            return data.replace(/(\r?\n)/g, '</span>$1<span class="hljs-comment">');
         })
         // Line numbers
         let l = parseInt(block.dataset.firstLineNumber);
         const contentTable = block.innerHTML.split(/\r?\n/).map(lineContent => {
            return '<tr>\
                      <td class="hljs-line">' + l++ + '</td>\
                      <td class="hljs-lineContent">' + lineContent + '</td>\
                    </tr>';
         }).join('');
         block.innerHTML = '<table class="hljs-table">' + contentTable + '</table>';
      }
  });
});