Create Or Replace view VW_ALL_POSTS As
Select r.ID, p.ID as PostID, UserName, FirstName, LastName, Gender, State, BirthYear, Category, Title, Description, PostDate, ExpireAfter
From REGISTRATION as r, POST as p
Where r.ID = p.UserID;

Drop procedure if exists SP_INSERT_USER;
Create Procedure SP_INSERT_USER(IN uname VARCHAR(50), IN pwd VARCHAR(60), IN salt CHAR(21), IN fn VARCHAR(50), IN ln VARCHAR(50), IN gender VARCHAR(5), IN state VARCHAR(20), IN byear CHAR(4))
insert into REGISTRATION values (null, uname, pwd, salt, fn, ln, gender, state, byear);


Drop procedure if exists SP_COUNT_USER;
Create Procedure SP_COUNT_USER(IN uname VARCHAR(50), IN pwd VARCHAR(60))
Select count(*) from REGISTRATION where username = uname and password = pwd;


Drop procedure if exists SP_FIND_USER_ID;
Create Procedure SP_FIND_USER_ID(IN uname VARCHAR(50), IN pwd VARCHAR(60))
Select ID as UID from REGISTRATION where username = uname and password = pwd;

Create Or Replace view VW_ALL_POSTS_WITH_PIC As
Select r.ID as UserID, UserName, FirstName, LastName, Gender, State, BirthYear, PostID, Category, Title, Description, PostDate, ExpireAfter, l.ID as PicID, PicLink
From REGISTRATION as r, POST as p, POST_PIC as l
Where r.ID = p.UserID and p.ID = l.PostID


Drop procedure if exists SP_GET_POSTS_BY_EMAIL;
Create Procedure SP_GET_POSTS_BY_EMAIL (IN uname VARCHAR(50)) 
select Category, Title, Description, PostDate, PostID  from VW_ALL_POSTS where UserName = uname;
