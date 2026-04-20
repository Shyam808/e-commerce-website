<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>practice</title>
</head>
<body>
    #reverse a string-------
    # text = "shyam"
    # rev = ""
    # for char in text:
    #     rev = char + rev
    # print(rev)

    #check a palindrome
    # s = "madam"
    # if(s == s[::-1]):
    #     print("string is palindrome")
    # else:
    #     print("not palindrome")

    #factorial
    # n = 5
    # fact = 1
    # for i in range(1, n+1):
    #     fact *= i 
    # print(fact)

    # find the largest number
    # lst = [10,20,50,30,90,95]
    # largest = lst[0]

    # for num in lst:
    #     if num > largest:
    #         largest = num
    # print(largest)

    # remove duplicate number
    # lst = [1,2,2,3,4,4,5]
    # unique = list(set(lst))
    # print(unique)


    # lst = [6,55,1,2,8,8,5,5,5,1]
    # unique = list(set(lst))
    # print(unique)

    # swap number without third variable
    # a = 10
    # b = 20
    # a,b =b,a
    # print(a,b)


    # prime number
    # n = 7
    # for i in range(2, n):
    #     if n % i == 0:
    #         print("Not Prime")
    #         break
    # else:
    #     print("Prime")

    # n = int(input("enter number : "))
    # for i in range(2, n+1):
    #     if n % 2 == 0:
    #         print("not prime")
    #         break
    # else:
    #     print("prime")


    # find sum of digits
    # n = 1234520
    # total = 0
    # while n > 0:
    #     total += n % 10
    #     n //= 10
    # print(total)

    

    # def func(*args, **kwargs):
    #     print(args)
    #     print(kwargs)


    # n = 12345
    # total = 0
    # while n > 0:
    #     total += n % 10
    #     n //= 10
    # print(total)



    # text = "madam"
    # if text == text[::-1]:
    #     print("palindrome")
    # else:
    #     ("not palindrome")


    # text = "python"
    # rev = ""
    # for i in text:
    #     rev = i + rev
    # print(rev)


    # n = 5
    # fact = 1
    # for i in range(1, n+1):
    #     fact *= i
    # print(fact)


    # n = 5
    # for i in range(2, n+1):
    #     if n % 2 == 0:
    #         print("not prime")
    #         break
    # else:
    #     print("prime")

    # n = 10

    # for i in range(2, n+1):
    #     if n % i == 0:
    #         print("not prime")
    #         break
    # else:
    #     print("prime")


    # lst = [10,20,50,60,80]
    # largest = lst[0]
    # for i in lst:
    #     if i > largest:
    #         largest = i
    # print(largest)

    # prime number
    # n = int(input("enter number : "))
    # if n<= 1:
    #     print("not prime")
    # else:
    #     for i in range(2, n+1):
    #         if n % i == 0:
    #             print("not prime")
    #             break
    #     else:
    #         print("prime")

    # count  vowels 
    # s = input("Enter string: ")
    # count = 0

    # for ch in s.lower():
    #     if ch in "aeiou":
    #         count += 1

    # print("Vowels:", count)

    # s = input("Enter String : ")
    # count = 0

    # for i in s.lower():
    #     if i in "aeiou":
    #         count += 1
    # print("vowels : ", count)


    # print odd or even
    # n = int(input("Enter number : "))

    # for i in range(1, 101):
    #     if i % 2 == 0:
    #         print(f"{i} number is Even")
    #     else:
    #         print(f"{i} number is Odd")


    # # print only Even num
    # for i in range(1, 101):
    #     if i % 2 == 0:
    #         print(f"{i} is Even")
    # # only for loop even number
    # for i in range(2, 101, 2):
    #         print(f"{i} is Even")


    # # print only odd
    # for i in range(1, 101, 2):
    #     print(f"{i} is Odd")




    n = int(input("Enter Number : "))
    for i in range(1, 100, 2):
        print(f"{i}")


        <li><a href="admin_dashboard.php" class="dropdown-item text-dark">Dashboard</a></li>
                    <li><a href="manage_items.php" class="dropdown-item text-dark">Manage products</a></li>
                    <li><a href="view_product.php" class="dropdown-item text-dark">View products</a></li>
                    <li><a href="orders.php" class="dropdown-item text-dark">Orders</a></li>
                    <li><a href="customers.php" class="dropdown-item text-dark">Customers</a></li>
                    <li><a href="logout.php" class="dropdown-item text-danger">Logout</a></li>
</body>
</html>