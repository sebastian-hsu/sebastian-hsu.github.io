
import os
if __name__=='__main__':
    for root, dirs, files in os.walk(".", topdown=False):
        for name in files:
            if name[-4:].lower() in ['.php', '.bak']:
                print(os.path.join(root, name))
                os.remove(os.path.join(root, name))