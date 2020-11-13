drop table if exists articles /*removing all tables if it exists*/ 
create table articles(
    ID smallint unsigned not null auto_increment,
    date_of_publication date not null, /*autoincremented primary key for the data*/
    article_title varchar(255) not null, /*var datatype for storing title*/
    article_summary text not null, /*text datatype for storing article summary*/
    article_content mediumtext not null,  /*mediumtext datatype for containing articles*/

    primary key (ID) /*setting primary key*/
);