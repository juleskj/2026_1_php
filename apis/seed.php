<?php

require_once __DIR__ . "/../db.php";
try{
    ini_set('memory_limit', '512M');
 

    $sql = "SELECT * FROM documents";
    $stmt = $_db->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();

    foreach ($rows as $row) {

        // makes the text looking json into an objcet
        $document_json = json_decode($row["document_json"]);
        $cases = $document_json->cases;
        $total_hits = $document_json->totalHits;

        if ($cases){
            foreach($cases as $item){
                $pk = bin2hex(random_bytes(25));
                $city_name = $item->address->cityName ?? null;
                $house_number = $item->address->houseNumber ?? null;
                $type = $item->addressType ?? null;
                $price = $item->priceCash ?? null;
                $lat = $item->coordinates->lat;	
                $lon = $item->coordinates->lon;
                $zip_code = $item->address->zipCode ?? null;
                $days_listed = $item->daysListed->days ?? null;
                $energy_label = $item->energyLabel ?? null;
                $monthly_expenses= $item->monthlyExpense ?? null;
                $lot_square_meters = $item->lotArea ?? null;
                $floor_square_meters = $item->housingArea ?? null;
                $road_name = $item->address->roadName ?? null;

                $main_image_path = $item->image->imageSources[0]->url ?? null;
                $floor_plan_path = $item->floorPlanImage->imageSources[0]->url ?? null;
                $number_of_rooms = $item->numberOfRooms ?? null;
                $price_per_meter = $item->perAreaPrice ?? null;
                                
                $number_of_baths = 0;
                $year_build = $item->yearBuilt ?? null;
                $main_image_alt = $item->image->imageSources[0]->alt ?? null;

                

                $sql = "INSERT INTO items(pk, lat, lon, price, type, city_name, house_number, road_name, zip_code, days_listed, energy_label, floor_square_meters, lot_square_meters, monthly_expenses, number_of_rooms, price_per_meter, main_image_path, floor_plan_path, deleted_at, number_of_baths, year_build, main_image_alt) 
                        VALUES (:pk,:lat,:lon,:price,:type,:city_name,:house_number,:road_name,:zip_code,:days_listed,:energy_label,:floor_square_meters,:lot_square_meters,:monthly_expenses,:number_of_rooms,:price_per_meter,:main_image_path,:floor_plan_path,'0',:number_of_baths,:year_build,:main_image_alt)";

                $stmt = $_db->prepare($sql);
                $stmt->bindValue(":pk", $pk);
                $stmt->bindValue(":lat", $lat);
                $stmt->bindValue(":lon", $lon);
                $stmt->bindValue(":price", $price);
                $stmt->bindValue(":type", $type);
                $stmt->bindValue(":city_name", $city_name);
                $stmt->bindValue(":house_number", $house_number);
                $stmt->bindValue(":road_name", $road_name);
                $stmt->bindValue(":zip_code", $zip_code);
                $stmt->bindValue(":days_listed", $days_listed);
                $stmt->bindValue(":energy_label", $energy_label);
                $stmt->bindValue(":floor_square_meters", $floor_square_meters);
                $stmt->bindValue(":lot_square_meters", $lot_square_meters);
                $stmt->bindValue(":monthly_expenses", $monthly_expenses);
                $stmt->bindValue(":number_of_rooms", $number_of_rooms);
                $stmt->bindValue(":price_per_meter", $price_per_meter);
                $stmt->bindValue(":main_image_path", $main_image_path);
                $stmt->bindValue(":floor_plan_path", $floor_plan_path);
                $stmt->bindValue(":number_of_baths", $number_of_baths);
                $stmt->bindValue(":year_build", $year_build);
                $stmt->bindValue(":main_image_alt", $main_image_alt);
                $stmt->execute();

                echo " " . "sucsess" . " "; 
                
             

            }

        }



        
        

        


    
    }

}catch (Exception $e){

echo "ups.." . $e;

}


/*
##############################
@app.get("/seed")
def seed():
    try:
        db, cursor = x.db()
        q = "SELECT * FROM documents" 
        cursor.execute(q)
        rows = cursor.fetchall()
 
        for row in rows:
            document = json.loads(row["document_json"]) 
            cases = document["cases"]
            total_hits = document["totalHits"]
            # # db = x.db()
            if cases:
                for item in cases:
                    # item_pk = item["address"]["addressID"]
                    pk = uuid.uuid4().hex
                    coordinates = item["coordinates"]
                    lat = coordinates["lat"]
                    lon = coordinates["lon"]
                    price = item["priceCash"]
                    _type = item["addressType"]
                    city_name = item["address"]["cityName"]
                    house_number = item.get("address", {}).get("houseNumber", "")
                    road_name = item["address"]["road"]["name"]
                    zip_code = item["address"]["zip"]["zipCode"]
                    days_listed = item["daysListed"]["days"]
                    energy_label = item.get("energyLabel", "")
                    floor_square_meters = item.get("housingArea", 0)
                    lot_square_meters = item.get("lotArea", 0)
                    monthly_expenses = item["monthlyExpense"]
                    number_of_rooms = item.get("numberOfRooms", 0)
                    price_per_meter = item.get("perAreaPrice", 0)
                    main_image_path = item.get("image", {}).get("imageSources", [{}])[0].get("url", "")
                    floor_plan_path = item.get("floorPlanImage", {}).get("imageSources", [{}])[0].get("url", "")
 
                    q = "INSERT INTO items VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
                    cursor.execute(q, (pk, lat, lon, price, _type, city_name, house_number, road_name, zip_code,
                    days_listed, energy_label, floor_square_meters, lot_square_meters, monthly_expenses,
                    number_of_rooms, price_per_meter, main_image_path, floor_plan_path))
                    db.commit()
                    ic("done with document")
        return "seed"
    except Exception as ex:
        ic(ex)
        return "ups..."
    finally:
        if "cursor" in locals(): cursor.close()
        if "db" in locals(): db.close()

*/
