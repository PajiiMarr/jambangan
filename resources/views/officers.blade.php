<x-layouts.app title="Officers">
         <style>
         
         /* border color */
        div.boc-light .boc-input>input{
            border-color: red ;
        }

        div.boc-light .boc-input>input:focus {
            border-color: red;
            color: gray;
        }


        /* the hovered search resutt */
        .boc-light .boc-search [data-search-item-id]:hover, .boc-light .boc-search [data-selected=yes] {
            background-color: rgb(151, 110, 110) !important;
        }
        [data-n-id] rect {
            transition: 0.15s ease-in-out;
        }

        [data-n-id] rect:hover {
            filter: drop-shadow( 4px 5px 5px #aeaeae);
        }

    </style>
   @livewire('officer-component')
</x-layouts.app>
