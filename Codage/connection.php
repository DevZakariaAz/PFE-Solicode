<?php
$dbn = 'mysql:host=localhost;dbname=tangorocco_v1';
$user = 'root';
$pass = '';

try {
    $conn = new PDO($dbn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'failed ' . $e->getMessage();
}
function fetchTopRestaurants($pdo) {
    $query = "
    SELECT 
        p.publicationid, 
        p.titre, 
        p.description, 
        p.coverimage, 
        AVG(r.rating) as average_rating
    FROM 
        publication p
    LEFT JOIN 
        review r ON p.publicationid = r.publicationid
    WHERE 
        p.location = 'Tangier' AND p.type = 'restaurant'
    GROUP BY 
        p.publicationid
    ORDER BY 
        average_rating DESC
    LIMIT 3";

    $statement = $pdo->prepare($query);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function fetchAllDestinationsV2($DB) {
    $query = "
        SELECT 
            p.publicationid, 
            p.titre, 
            p.description, 
            p.location, 
            p.coverimage, 
            GROUP_CONCAT(DISTINCT c.category) AS categories, 
            cu.nationalite AS cuisine, 
            COUNT(r.reviewid) AS review_count, 
            AVG(r.rating) AS average_rating 
        FROM 
            publication p
        LEFT JOIN 
            category_publication cp ON p.publicationid = cp.publicationid 
        LEFT JOIN 
            category c ON cp.categoryid = c.categoryid 
        LEFT JOIN 
            cuisine cu ON p.cuisineid = cu.cuisineid
        LEFT JOIN 
            review r ON p.publicationid = r.publicationid 
        WHERE 
            p.type = 'destination' 
        GROUP BY 
            p.publicationid
        ORDER BY 
            average_rating DESC;
    ";

    $statement = $DB->prepare($query);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
function searchDestinations($conn, $searchQuery) {
    $query = "SELECT p.*, AVG(r.rating) AS average_rating, COUNT(r.reviewid) AS review_count 
              FROM publication p 
              LEFT JOIN review r ON p.publicationid = r.publicationid 
              WHERE p.titre LIKE :searchQuery OR p.description LIKE :searchQuery
              GROUP BY p.publicationid";

    $stmt = $conn->prepare($query);
    $searchParam = "%{$searchQuery}%";
    $stmt->bindParam(':searchQuery', $searchParam, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function fetchTopDestinations($DB) {
    $query = "
    SELECT 
    p.publicationid, 
    p.titre, 
    p.description, 
    p.coverimage, 
    COUNT(r.reviewid) as review_count,
    AVG(r.rating) as average_rating
FROM 
    publication p
LEFT JOIN 
    review r ON p.publicationid = r.publicationid
WHERE 
    p.location = 'Tangier' AND p.cuisineid IS NULL
GROUP BY 
    p.publicationid
ORDER BY 
    average_rating DESC
LIMIT 3;

";

    $statement = $DB->prepare($query);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

//fetch reviews 

?>
