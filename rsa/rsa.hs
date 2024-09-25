import System.IO
import System.Random
import Data.Maybe

--Translation tables for String -> Int representation and vice versa
asciiTableDec :: [(Integer, String)]
asciiTableDec = [
    (48, "0"), (49, "1"), (50, "2"), (51, "3"), (52, "4"), (53, "5"), (54, "6"), (55, "7"), (56, "8"), (57, "9"), 
    (65, "A"), (66, "B"), (67, "C"), (68, "D"), (69, "E"), (70, "F"), (71, "G"), (72, "H"), (73, "I"), (74, "J"), 
    (75, "K"), (76, "L"), (77, "M"), (78, "N"), (79, "O"), (80, "P"), (81, "Q"), (82, "R"), (83, "S"), (84, "T"), 
    (85, "U"), (86, "V"), (87, "W"), (88, "X"), (89, "Y"), (90, "Z"), 
    (97, "a"), (98, "b"), (99, "c"), (100, "d"), (101, "e"), (102, "f"), (103, "g"), (104, "h"), (105, "i"), (106, "j"), 
    (107, "k"), (108, "l"), (109, "m"), (110, "n"), (111, "o"), (112, "p"), (113, "q"), (114, "r"), (115, "s"), (116, "t"), 
    (117, "u"), (118, "v"), (119, "w"), (120, "x"), (121, "y"), (122, "z"), (123, " ")
    ]

asciiTableEnc :: [(String, Integer)]
asciiTableEnc = [
    ("0", 48), ("1", 49), ("2", 50), ("3", 51), ("4", 52), ("5", 53), ("6", 54), ("7", 55), ("8", 56), ("9", 57), 
    ("A", 65), ("B", 66), ("C", 67), ("D", 68), ("E", 69), ("F", 70), ("G", 71), ("H", 72), ("I", 73), ("J", 74), 
    ("K", 75), ("L", 76), ("M", 77), ("N", 78), ("O", 79), ("P", 80), ("Q", 81), ("R", 82), ("S", 83), ("T", 84), 
    ("U", 85), ("V", 86), ("W", 87), ("X", 88), ("Y", 89), ("Z", 90), 
    ("a", 97), ("b", 98), ("c", 99), ("d", 100), ("e", 101), ("f", 102), ("g", 103), ("h", 104), ("i", 105), ("j", 106), 
    ("k", 107), ("l", 108), ("m", 109), ("n", 110), ("o", 111), ("p", 112), ("q", 113), ("r", 114), ("s", 115), ("t", 116), 
    ("u", 117), ("v", 118), ("w", 119), ("x", 120), ("y", 121), ("z", 122), (" ",123)
    ]


--converts the input from file to a list of integers
readRawCypher::String->[Integer]
readRawCypher = map read . words


--prints the encrypted Integers into a file
outputCypher::[Integer]->Handle->IO()
outputCypher (current:[]) outHandle = hPutStr outHandle (show current)
outputCypher (current:encList) outHandle = do
    hPutStr outHandle ((show current)++" ")
    outputCypher encList outHandle

--returns the Maybe String from lookup function into non-maybe value
--adds [Unknown Character] if character is not in translate table
unjustChar::Maybe String -> String
unjustChar Nothing = "[Unknown Character]"
unjustChar (Just input) = input

--converts given integer into string via lookup table - lookup returns Maybe => call unjustChar
lookupCharByCode :: Integer -> String
lookupCharByCode code = (unjustChar (lookup code asciiTableDec))

--converts list of integers into string, according to translation table
numToText :: [Integer] -> String
numToText (last:[]) = (lookupCharByCode last)
numToText (current:rest) =(lookupCharByCode current) ++ numToText rest 

--converts given char into into via translation table
lookupCodeByChar :: String -> Maybe Integer
lookupCodeByChar char = lookup char asciiTableEnc

--converts Maybe Integer into given Integer
unjustInt::Maybe Integer -> Integer
unjustInt (Just input) = input
unjustInt Nothing = 124 --maps unknown Characters to unused 124 -> is not in table so it will become [Unknown Character] later

--Converts a String into a list of Integers, coded by every char
textToNum :: String -> [Integer]
textToNum input = map (unjustInt . lookupCodeByChar . (:[])) input

--converts the key-input string into proper (Integer,Integer) form
parseKey::String->(Integer,Integer)
parseKey string = read string :: (Integer,Integer)

--converts the read string into actual integers
parseMessage::String->Integer
parseMessage string = read string::Integer


--the actual encryption/decryption function
--since c^d = (m^e)^d = m (mod n) its the same function, but different key gets passed
doCryption::[Integer]->[Char]->[Integer]
doCryption [] _ = []
doCryption (message:messageList) keyString = ((message^e) `mod` n):doCryption messageList keyString
    where 
        key = parseKey keyString
        e = snd key
        n = fst key

--private to save new keys into a file with given user input name
exportKeys::Integer->Integer->Integer->Integer->IO()
exportKeys modulo privEx pubEx phi_n = do
    putStrLn "What should the name of your key be?"
    inputName <- getLine
    pubHandle <- openFile (inputName++".pub") WriteMode
    privHandle <- openFile (inputName++".priv") WriteMode
    hPutStrLn pubHandle (show (modulo,pubEx))
    if privEx <= 0 then hPutStrLn privHandle (show (modulo,(privEx+phi_n)))
    else hPutStrLn privHandle (show (modulo,privEx))
    hClose pubHandle
    hClose privHandle

--calculates the modular multiplicative inverse of carmichael(n) and 65537
extendedGCD :: (Integer,Integer) -> (Integer, Integer)
extendedGCD (a,b)
    | (b == 0) = (1,0) 
    | otherwise = (t, z) 
    where (s,t) = extendedGCD(b, a `mod` b)
          z = s - ( (a `div` b) * t)

--checks if a and b are coprime => gcd(a,b) == 1
isCoprime::Integer->Integer->Bool
isCoprime a b = gcd a b == 1

--creates a list of numbers which are smaller than input limit and also comprime with limit
coprime::Integer->[Integer]
coprime limit = [x | x<-[2..limit],isPrime x, isCoprime limit x]

--calculating least common multiple with this formula: |ab|/gcd(a,b)
leastCommonMultiple::Integer->Integer->Integer 
leastCommonMultiple p q = (div (p*q) (gcd p q))

--gives a random large integer for given bitlength (from range 2^(bitlength-1) to (2^bitlength)-1)
randomLargeInt::Int->IO Integer
randomLargeInt bitlength = do randomRIO(2^(bitlength-1),(2^bitlength)-1)

--checks if given integer n is prime
isPrime :: Integer -> Bool
isPrime n
    | even n = False
    | otherwise = not (any (\x -> n `mod` x == 0) [3,5..(floor . sqrt $ fromIntegral n)]) --checks every odd number from 3 to sqrt n


--creates a random large prime for key creation by
-- taking random large ints of given length and then checking them for prime
--also checks if they are coprime to public exponent 65537, just to make sure it doesnt fail later
randomLargePrime::Int->IO Integer
randomLargePrime bitlength = do 
    candidate <- randomLargeInt bitlength
    if isPrime candidate && (isCoprime candidate 65537) then return candidate
    else randomLargePrime bitlength

--creates a new pair of keys
create::IO()
create = do
    putStrLn "What bitlength do you want to use? [16,32]?"  --could in theory be any 2^x, but larger bitlength take a long time to compute
    input <- getLine                                        --16 and 32 is just to show the code works, since it wont be used for any real encryption there is no need to use higher bitlengths
    let bitlength = read input::Int
    if bitlength /= 16 && bitlength /= 32 then do --check if bitlength input is 16 or 32, if not calls create again
        putStrLn "Sorry, the bitlength has to be 16 or 32"
        create
    else do --https://en.wikipedia.org/wiki/RSA_(cryptosystem)
        p <- randomLargePrime bitlength --get two large random primes
        q <- randomLargePrime bitlength
        let n = p*q --calculate factor of those
        let carmichael_n = leastCommonMultiple (p-1) (q-1) --calculate carmichaels totient function of n - since p and q are primes it is lcm(p-1,q-1)
        let e = 65537 -- default public exponent - https://crypto.stackexchange.com/questions/3110/impacts-of-not-using-rsa-exponent-of-65537
        let d = snd( extendedGCD (carmichael_n,e)) --calculates the modular multiplicative inverse of carmichael(n) and 65537 - c^d = (m^e)^d = m (mod n) for c being encrypted m (m^e)
        exportKeys n d e carmichael_n --exports the newly created keys

decrypt::IO()
decrypt = do
        putStrLn "Please state the name of the file you want to decrypt" --read encrypted message
        d_input<-getLine
        inputHandle<-openFile d_input ReadMode
        content<-hGetContents inputHandle

        let parsedMsg = readRawCypher content --converts string input into list of integers

        putStrLn "What is the name of the private key?" --read private key to decrypt
        keyName <- getLine
        keyHandle <- openFile keyName ReadMode
        key <-hGetContents keyHandle

        let numMessage = doCryption parsedMsg key --decrypts the integers, its still in integer format though

        putStrLn "What should the name of the output file be?" --prepares output file
        d_output <- getLine
        messageHandle<-openFile d_output WriteMode

        let clearText = numToText numMessage --translates message from integer format to string with translation table

        hPutStrLn messageHandle clearText --writes clear text into output file

        hClose inputHandle
        hClose keyHandle
        hClose messageHandle

encrypt::IO()
encrypt = do
        putStrLn "Please state the name of the file you want to encrypt" --reads message to encrypt
        e_input<-getLine
        inputHandle<-openFile e_input ReadMode
        content<-hGetContents inputHandle

        let numMessage = textToNum content --converts string into integer representation with translation table

        putStrLn "What is the name of the public key?" --reads public key to encrypt message
        keyName <- getLine
        keyHandle <- openFile keyName ReadMode
        key <-hGetContents keyHandle

        let encryptedList = doCryption numMessage key --encrypts the message

        putStrLn "What should the name of the output file be?" --prepares output file
        e_output <- getLine
        messageHandle<-openFile e_output WriteMode

        outputCypher encryptedList messageHandle --prints encrypted message into file

        hClose inputHandle
        hClose keyHandle
        hClose messageHandle


main::IO()
main = do
    putStrLn "Welcome to my RSA Key tool - written by Julius Hamel"
    putStrLn "Do you want to create a new pair of keys, decrypt a message or encrypt a message?"
    putStrLn "Please answer with c,d or e"
    toolSelection<-getLine
    if toolSelection == "c" then create
    else if toolSelection == "d" then decrypt
    else if toolSelection == "e" then encrypt
    else error "Wrong input, please try again"
