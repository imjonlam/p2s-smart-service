<?php
	include 'db_manager.php';

	$man = new db_manager('localhost', 'root', '', 'cps630_proj_db');
	$result = $man->select($_POST['table'], $_POST);
    $input_row = [];
    if(isset($_POST['insert'])) {
        $input_row['Cars'] = <<<EOD
              <tr>
                <td></td>
                <td><input type="text" name="model" id="model" class="form-control" required></td>
                <td><input type="text" name="vin" id="vin" class="form-control" required></td>
                <td><input type="text" name="desc" id="desc" class="form-control" required></td>
                <td><input type="number" name="price" id="price" class="form-control" min="0" step="0.01" required></td>
                <td><input type="text" name="logo" id="logo" class="form-control" required></td>
                <td><input type="number" name="avail" id="avail" class="form-control" min="1" required></td>
                <td><a id='#ins-btn' type='button' target='_blank' class='btn btn-primary'>Insert</a></td>
              </tr>
              EOD;

        $input_row['Coffees'] = <<<EOD
              <tr>
                <td></td>
                <td><input type="text" name="name" id="name" class="form-control" required></td>
                <td><input type="number" name="code" id="code" class="form-control" min="1" required></td>
                <td><input type="number" name="price" id="price" class="form-control" min="0" step="0.01" required>
                <td><input type="text" name="logo" id="logo" class="form-control" required></td>
                <td><a id='#ins-btn' type='button' target='_blank' class='btn btn-primary'>Insert</a></td>
              </tr>
              EOD;

        $input_row['Flowers'] = <<<EOD
              <tr>
                <td></td>
                <td><input type="text" name="name" id="name" class="form-control" required></td>
                <td><input type="number" name="code" id="code" class="form-control" min="1" required></td>
                <td><input type="number" name="price" id="price" class="form-control" min="0" step="0.01" required>
                <td><input type="text" name="logo" id="logo" class="form-control" required></td>
                <td><a id='#ins-btn' type='button' target='_blank' class='btn btn-primary'>Insert</a></td>
              </tr>
              EOD;

        $input_row['Shops'] = <<<EOD
              <tr>
                <td></td>
                <td><input type="text" name="name" id="name" class="form-control" required></td>
                <td><input type="text" name="cat" id="cat" class="form-control" required></td>
                <td><input type="text" name="add" id="add" class="form-control" required></td>
                <td><input type="text" name="logo" id="logo" class="form-control" required></td>
                <td><a id='#ins-btn' type='button' target='_blank' class='btn btn-primary'>Insert</a></td>
              </tr>
              EOD;

        $input_row['Trips'] = <<<EOD
              <tr>
                <td></td>
                <td><input type="text" name="source" id="source" class="form-control" required></td>
                <td><input type="text" name="dest" id="dest" class="form-control" required></td>
                <td><input type="text" name="dist" id="dist" class="form-control" required></td>
                <td><input type="text" name="city" id="city" class="form-control" required></td>
                <td><input type="number" name="car" id="car" class="form-control" min="1" required></td>
                <td><input type="number" name="price" id="price" class="form-control" min="0" step="0.01" required></td>
                <td><a id='#ins-btn' type='button' target='_blank' class='btn btn-primary'>Insert</a></td>
              </tr>
              EOD;

        $input_row['Users'] = <<<EOD
              <tr>
                <td></td>
                <td><input type="text" name="name" id="name" class="form-control" required></td>
                <td><input type="tel" id="phone" name="phone" class="form-control" pattern="([0-9]{3}-[0-9]{3}-[0-9]{4})||[0-9]{10}" required></td>
                <td><input type="text" name="email" id="email" class="form-control" required></td>
                <td><input type="text" name="city" id="city" class="form-control" required></td>
                <td><input type="text" name="username" id="username" class="form-control" required></td>
                <td><input type="password" name="password" id="password" class="form-control" required></td>
                <td></td>
                <td><input type="number" name="bal" id="bal" class="form-control" min="0" step="0.01" required></td>
                <td class='col-md-1'><select id='role' name='role' class='form-control'><option value='user'>User</option><option value='admin'>Admin</option></select></td>
                <td><a id='#ins-btn' type='button' target='_blank' class='btn btn-primary'>Insert</a></td>
              </tr>
              EOD;
      }
    
    elseif(isset($_POST['update'])) {
        $input_row['Cars'] = "model,vin,desc,price,logo,avail";

        $input_row['Coffees'] = "name,store,price,logo";
        
        $input_row['Flowers'] = "name,store,price,logo";

        $input_row['Shops'] = "name,category,address,logo";

        $input_row['Trips'] = "source,dest,dist,city,car,price";

        $input_row['Users'] = "name,phone,email,city,username,password,salt,bal,role";
    }
    
	if(!$result) {
		echo $man->error();
	} else {
        $div = '';
        if(isset($_POST['update']))
            $div .= "<input type='hidden' id='cols' value='{$input_row[$_POST['table']]}'>";
        $div .= "<table>";
		if ($result->num_rows > 0) {
			$iter = 0;
			foreach($result as $row) {
         		$div .= "<tr>";
				if(!$iter) {
					foreach($row as $key => $value) {
						$div .= "<th>";
						$div .= "{$key}";
						$div .= "</th>";
					}
					if(isset($_POST['del_btn']) && $_POST['del_btn'] == true)
						$div .= "<th></th>";
					$div .= "</tr><tr>";
					$iter = 1;
				}
				foreach($row as $key => $value) {
					$div .= "<td>";
					if ($value == NULL)
						$div .= "---";
					else
						$div .= "{$value}";
					$div .= "</td>";
				}
				if(isset($_POST['del_btn']) && $_POST['del_btn'] == true) {
					$div .= "<td>";
					$div .= "<a id='#del-btn' type='button' target='_blank' data-id='{$row['id']}' class='btn btn-primary'>Delete</a>";
					$div .= "</td>";
					$div .= "</tr>";
				}
          	}
            if(isset($_POST['insert']) && $_POST['insert'] == true)
                $div .= $input_row[$_POST['table']];
			echo $div;
		}
		else {
          if(isset($_POST['insert']) && $_POST['insert'] == true) {
                $div .= '<tr>';
                foreach($result->fetch_fields() as $key => $field) {
                  $div .= "<th>{$field->name}</th>";
                }
                $div .= '</tr>';
                $div .= $input_row[$_POST['table']];
                echo $div;
          } else
			echo "Zero items in table";
		}
	}
?>