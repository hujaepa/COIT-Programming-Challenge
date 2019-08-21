#include <iostream>
int main(){
using namespace std;
int a,b,ans,count=0;
char tc;
cin>>tc;
while(tc!=0){
cin>>a;
cin>>b;
ans=a+b;
cout<<"case #"<<++count<<":"<<ans<<endl;
--tc;
}//end of tc
return 0;
}
