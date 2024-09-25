This is my RSA-Key tool, which is my Semester Project for the non-procedural programming course of the Charles University in 2024.

---Prerequiries
To run this program you have to have ghci installed.
Additionally you also need the System.Random package
I did it by creating an package environment in the same direcotry as the rsa.hs file with:
cabal install --lib --package-env . random

---Running the tool
The Tool can be started by runghc rsa.hs or loading it into ghci and run the main function

You will be greated by this text interface
>runghc rsa.hs
Welcome to my RSA Key tool - written by Julius Hamel
Do you want to create a new pair of keys, decrypt a message or encrypt a message?
Please answer with c,d or e

You can choose whether you want to 
    -create a new pair of keys with (c)
    -decrypt an encrypted message with your private key (d)
    -encrypt a message with an public key (e)

---CREATING A PAIR OF KEYS

-------------------------------------------
Please answer with c,d or e
c
What bitlength do you want to use? [16,32]?
-------------------------------------------

After answering with c you will be asked to enter a bitlength.
Since this tool will not be used for actual encryptions and is only supposed to show that it works i limited the input to 16 or 32 bits.
I would use 16bits to check functionality, because even with that the decryption takes a little while.
Encryption and key generation are generally pretty fast.

-------------------------------------------
What bitlength do you want to use? [16,32]?
32
What should the name of your key be?
-------------------------------------------
After choosing the bitlength you are promted to enter a new for your keys
The keys will be created and saved as <name>.pub and <name>.priv



---Decrypting a message

-----------------------------------------------------
Please answer with c,d or e
d
Please state the name of the file you want to decrypt
-----------------------------------------------------
As prompted, please enter the name of the file you want to decrypt.
The input works with the relative path from the directory where the rsa.hs file is saved and the absolute path on the computer

-----------------------------------------------------
Please state the name of the file you want to decrypt
<secret>.enc
What is the name of the private key?
-----------------------------------------------------
Similarly as with the input, you need to enter the relative path or the absolute path of the private key you want to use

-----------------------------------------------------
What is the name of the private key?
<keyname>.priv
What should the name of the output file be?
-----------------------------------------------------
you can enter the relative or absolute path of where you want to safe the decrypted output file


---Encrypting a message

This generally works exactly as the decryption of a message


---Created by Julius Hamel