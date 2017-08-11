<form method="POST" action="">
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="start">
            <a data-toggle="tab" href="#form_start" class="btn btn-success">
                Tak
            </a>
            <a href="http://gpec.oxmedia.pl/jak-sie-przylaczyc/" class="btn btn-danger">
                Nie
            </a>
        </div>
        <!-- <div role="tabpanel" class="tab-pane" id="form_start"> -->
        <div role="tabpanel" id="form_start">
            <div class="form-group">
                <label for="city">Wybierz miasto</label>
                <select class="form-control" id="city"><?php
                    foreach($cities as $city)
                        printf('<option value="%s">%s</option>',$city->{'city'},$city->{'city'});
                ?></select>
            </div>
            <div class="form-group">
                <label for="street">Wpisz nazwę ulica</label>
                <input type="text" class="form-control" id="street" list="street_list" placeholder="Ulica">
                <datalist id="street_list"><?php
                    foreach($streets as $street)
                        printf('<option value="%s" data-city="%s">%s</option>',$street->{'street'},$street->{'city'},$street->{'street'});
                ?></datalist>
            </div>
            <div class="form-group">
                    <label for="number">Wpisz numer domu</label>
                    <input type="text" class="form-control" id="number" placeholder="Numer domu">
            </div>
            <div class="form-group">
                <label for="number_local">Wpisz numer lokalu</label>
                <input type="text" class="form-control" id="number_local" placeholder="Numer lokalu">
            </div>
            <button type="button" class="btn btn-primary">Szukaj</button>
        </div>
    </div>
</form>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script> -->