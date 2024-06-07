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
