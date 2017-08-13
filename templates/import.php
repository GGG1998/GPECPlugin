<h1>Import bazy danych GPEC</h1>
<p style="margin-left: 50px;">
    <h2 style="color:red;">FAQ!</h2>
    <ol class="faq">
        <ul>Obsługiwane formaty i dodatkowe infrmacje
            <li>Obsługiwane formaty: <strong>*.csv</strong></li>
            <li>Pola muszą mieć zachowaną kolejność(<i>Patrz na wymagane pola</i>)</li>
            <li>Pola oddzielamy średnikami</li>
            <li>Przykład(<i>Lista klientów</i>):
                <code>
                    city;street;number_flat;number_home;group_client;company;
                    Gdańsk;Wilanowska;5b;10;85D;GPEC;
                </code>
            </li>
        </ul>
        <ul>Wymagane pola <i>"Listy klientów"</i>
            <li>Miasto: <i>"city"</i></li>
            <li>Ulica: <i>"street"</i></li>
            <li>Numer budynku: <i>"number_flat"</i></li>
            <li>Numer lokalu: <i>"number_home"</i></li>
            <li>Grupa taryfowa: <i>"group_client"</i></li>
            <li>Spółka: <i>"company"</i></li>
        </ul>
        <ul>Wymagane pola <i>"Reguły spinające"</i>
            <li>Grupa taryfowa: <i>"value"</i></li>
            <li>kod grupy: <i>"group_code"</i></li>
        </ul>
        <ul>Wymagane pola <i>"Ceny taryf"</i>
            <li>Grupa taryfowa: <i>"value"</i></li>
            <li>Suma opłat stałych i zmiennych za MW/rok(brutto): <i>"sum_brutto_year"</i></li>
            <li>Suma opłat stałych i zmiennych za MW/rok(VAT): <i>"sum_vat_year"</i></li>
            <li>Suma opłat stałych i zmiennych za MW/rok(netto): <i>"sum_netto_year"</i></li>
            <li>Suma opłat stałych i zmiennych za GJ (brutto): <i>"sum_brutto_gj"</i></li>
            <li>Suma opłat stałych i zmiennych za GJ(VAT): <i>"sum_vat_gj"</i></li>
            <li>Suma opłat stałych i zmiennych za GJ(netto): <i>"sum_netto_gj"</i></li>
        </ul>
    </ol>
</p>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="list_clients">Wybierz plik zawierający listę klientów</br>
    <input type="file" name="list_rules">Wybierz plik zawierający reguły spinające</br>
    <input type="file" name="list_costs">Wybierz plik zawierający ceny taryf</br>
    <input type="submit" value="Wyślij" name="send"/>
</form>
<script>
    jQuery(document).ready(function($){
        $(".faq ul").click(function(){
            $(this).find("li").toggle();
        })
    });
</script>