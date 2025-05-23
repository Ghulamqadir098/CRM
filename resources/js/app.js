import './bootstrap';
import { DataTable } from 'simple-datatables';
// import { DataTable } from "simple-datatables";
import "simple-datatables/dist/style.css";

import $ from 'jquery';
window.$ = window.jQuery = $;



document.addEventListener("DOMContentLoaded", function () {
    const table = document.querySelector("#my-table-id");
    if (table) {
        new DataTable(table,{
            perPage: 10,
            perPageSelect: [10, 20, 30, 50, 100],
        });
    }
    const table2 = document.querySelector("#my-table-id-2");
    if (table2) {
        new DataTable(table2,{
            perPage: 10,
            perPageSelect: [10, 20, 30, 50, 100],
        });
    }
    const table3 = document.querySelector("#my-table-id-3");
    if (table3) {
        new DataTable(table3,{
            perPage: 10,
            perPageSelect: [10, 20, 30, 50, 100],
        });
    }
    const table4 = document.querySelector("#my-table-id-4");
    if (table4) {
        new DataTable(table4,{
            perPage: 10,
            perPageSelect: [10, 20, 30, 50, 100],
        });
    }
});